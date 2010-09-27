var map = null;
var vector_layer = null;
var connection_layer = null;
var buttons_layer = null;
var linking = false;
var starting_feature = null;
var popup_layer = null;
var MaxSizeAnchoredBubble = OpenLayers.Class(OpenLayers.Popup.AnchoredBubble, {'autoSize': true});
var active_popup;
var active_popupFlag=true;
var tool_permanent = false;
var tool = "";
var selected_feature = null;
var AutoSizeAnchored = OpenLayers.Class(OpenLayers.Popup.Anchored, {'autoSize': true});
var last_feature_pos = null;
var last_closest_line = -1;

$(document).ready(function() {
	var maxExtent = new OpenLayers.Bounds(0, 0, 20037508.34, 20037508.34);
	var EPSG900913 = new OpenLayers.Projection("EPSG:900913");
	map = new OpenLayers.Map('map',	{ maxExtent: maxExtent, numZoomLevels: 22, maxResolution: 200000.0, units: 'm', projection: EPSG900913});
	createControls();
	createLayers();
	createDraggers();
	//map.zoomToMaxExtent();
	map.events.register("click", map, map_click);
	var centerPoint = new OpenLayers.LonLat(10000000,10000000);
	map.setCenter(centerPoint, 18);
	$("#tool_select").click(activateSelectors);
	$("#tool_link").click(activateLinker);
	$("#tool_state").click(function(){setTool("state")});
	$("#tool_unlink").click(function(){setTool("unlink")});
	$("#tool_delete").click(function(){setTool("delete")});
	$("#tool_select").click();
	$("#tool_decision").click(function(){setTool("decision")});
	$("#tool_edit").click(editService);
	map.events.register("mousemove", map, mapMouseMove);
	map.events.register("click", map, mapClick);
	loadModel();
})

function deleteSelected(){
	if(selected_feature!=null){
		$.ajax( { type : "POST", url : "?pg=states&action=del", cache : false, data: {"id":selected_feature.attributes.id}, success : function(d){
		}});
		if(selected_feature.attributes.type=="decisions" || selected_feature.attributes.type=="states"){
			if(selected_feature.text_multiline != undefined) selected_feature.text_multiline.destroy();
			for ( var i in selected_feature.from_lines)
				selected_feature.from_lines[i].destroy();
			for ( var i in selected_feature.to_lines)
				selected_feature.to_lines[i].destroy();
		}
		if(active_popup)
			map.removePopup(active_popup.popup);
		selected_feature.destroy();
		vector_layer.redraw();
		selected_feature = null;
	}
}

function mapClick(){
	if(tool == "unlink" && last_closest_line != -1){
		$.ajax( { type : "POST", url : "?pg=connections&action=del", cache : false, data: {"id":connection_layer.features[last_closest_line].attributes.id}, success : function(d){
			connection_layer.features[last_closest_line].destroy();
			connection_layer.redraw();
		}});
		
	}
}

function mapMouseMove(e) {
	if(tool=="unlink"){
		var mousepos = connection_layer.getLonLatFromViewPortPx(e.xy);
		var ft1 = new OpenLayers.Geometry.Point(mousepos.lon, mousepos.lat);
		var min_dist = 100;
		var min_i = -1;
		for(var i in connection_layer.features){
			if(connection_layer.features[i].geometry.CLASS_NAME=="OpenLayers.Geometry.LineString"){
				var DistBetween = new OpenLayers.DistBwPointAndLine(connection_layer.features[i].geometry, ft1);
				if(DistBetween.distMin<min_dist){
					min_dist = DistBetween.distMin;
					min_i = i;
				}
			}
		}
		if(min_i!=last_closest_line){
			for(var i in connection_layer.features){
				connection_layer.features[i].style = {strokeColor: "#ee9900", strokeWidth: 1};
			}
			if(min_i != -1)
				connection_layer.features[min_i].style = {strokeColor: "#EE1111", strokeWidth: 3};
			connection_layer.redraw();
			last_closest_line = min_i;
		}
	}
}

function editService(){
	tb_show("Edit service description", $(this).attr("href")+"&amp;TB_iframe=true&amp;height=350&amp;width=400", null);
}

function loadModel(){
	$.ajax( { type : "GET", url : "./?pg=service&action=list_contents", cache : false, dataType: "json", success : function(d){
		$(d[0].states).each(function(){
			var features = createState(this.x, this.y, this.w, this.h, this.id, this);
			vector_layer.addFeatures(features);
			addLabel(features[0]);
			centerTextIntoBlock(features[0]);
		});
		$(d[1].decisions).each(function(){
			var features = createDecision(this.x, this.y, this.w, this.h, this.id, this);
			vector_layer.addFeatures(features);	
			addLabel(features[0]);
			centerTextIntoBlock(features[0]);
		});
		$(d[2].connections).each(function(){
			for(var i in vector_layer.features){
				if(vector_layer.features[i].attributes.id==this.id1){
					for(var ii in vector_layer.features){
						if(vector_layer.features[ii].attributes.id==this.id2){
							connectWithLine(vector_layer.features[i], vector_layer.features[ii], this.id);
						}
					}
				}
			}
		});
		map.zoomToExtent(vector_layer.getDataExtent(), true);
	}});
}

function createState(left, top, width, height, id, record){
	var features = [];
	features.push(new OpenLayers.Feature.Vector(new OpenLayers.Bounds(left, top+height, left+width, top).toGeometry(), {id: id, "type" : "states", record : record}, {fillColor:"#eeeeee", opacity: 1, strokeColor: "#339933", strokeOpacity: 1, strokeWidth: 2}));
	features[0].from_lines = [];
	features[0].to_lines = [];
	return features;
}

function getDecisionGeometry(left, top, width, height){
	return new OpenLayers.Geometry.LinearRing([
		new OpenLayers.Geometry.Point(left + 10, top), 
		new OpenLayers.Geometry.Point(left, top + 10),
		new OpenLayers.Geometry.Point(left, top + height - 10), 
		new OpenLayers.Geometry.Point(left + 10, top + height), 
		new OpenLayers.Geometry.Point(left + width - 10, top + height), 
		new OpenLayers.Geometry.Point(left + width, top + height - 10), 
		new OpenLayers.Geometry.Point(left + width, top + 10), 
		new OpenLayers.Geometry.Point(left + width - 10, top)
	])
}

function createDecision(left, top, width, height, id, record){
	var features = [];
	features.push(new OpenLayers.Feature.Vector(getDecisionGeometry(left, top, width, height), {id: id, "type" : "decisions", record : record}, {fillColor:"#eeeeee", opacity: 1, strokeColor: "#339933", strokeOpacity: 1, strokeWidth: 2}));
	features[0].from_lines = [];
	features[0].to_lines = [];
	return features;
}

function createSimpleLine(point1, point2){
	var features = [];
	features.push(new OpenLayers.Feature.Vector(new OpenLayers.Geometry.LineString([point1, point2])));
	return features;
}

function createControls(){
	map.addControl(new OpenLayers.Control.LayerSwitcher());
	map.addControl(new OpenLayers.Control.MousePosition());
}

function createLayers(){
	var blyr = new OpenLayers.Layer("BaseLayer");
	blyr.isBaseLayer=true;
	blyr.displayInLayerSwitcher = false;
	map.addLayer(blyr);

	//Create layers
	//map.addLayer(new OpenLayers.Layer.Google("Google Satellite", { 'type': G_SATELLITE_MAP }));
	connection_layer = new OpenLayers.Layer.Vector("Connecting lines");
	vector_layer = new OpenLayers.Layer.Vector("Edgy things and text");
	popup_layer = new OpenLayers.Layer("Info windows");
	//Add layers
	map.addLayer(connection_layer);
	map.addLayer(vector_layer);
	map.addLayer(popup_layer);
	
	$('ul#icons li').hover(
		function() { $(this).addClass('ui-state-hover'); }, 
		function() { $(this).removeClass('ui-state-hover'); }
	);
}

function createDraggers(){
	ctrlDragState = new OpenLayers.Control.DragFeature(vector_layer, {geometryTypes:["OpenLayers.Geometry.Polygon", "OpenLayers.Geometry.LinearRing"]});
	map.addControl(ctrlDragState);
	ctrlDragState.onDrag = featureMove;
	ctrlDragState.onComplete = featureMoved;
	ctrlDragState.onStart = featureSelected;
	ctrlDragState.activate();
}

function activateLinker(){
	setTool("link")
	activateSelectors(false);
	linking = true;
	starting_feature = null;
}

function activateSelectors(highlight_tool){
	if(highlight_tool==undefined) highlight_tool = true;
	if(highlight_tool) setTool("select");
	ctrlDragState.activate();
}

function setTool(which){
	resetSelectedFeature();
	$("#tool_"+tool).removeClass("selected");
	tool = which;
	$("#tool_"+which).addClass("selected");
	linking = false;
}

function resetSelectedFeature(){
	starting_feature.style.fillColor = "#eeeeee";
	starting_feature.style.strokeWidth = 2;
	vector_layer.drawFeature(starting_feature);
}

function featureSelected(feature){
	if(feature.attributes.type=="decisions" || feature.attributes.type=="states"){
		last_feature_pos = feature.geometry.getBounds().toArray();
		if(linking){
			if(starting_feature == null){
				starting_feature = feature;
				starting_feature.style.fillColor = "#888888";
				starting_feature.style.strokeWidth = 3;
				vector_layer.drawFeature(starting_feature);
			} else {
				$.ajax( { type : "POST", url : "?pg=connections&action=add", cache : false, data: {"id1": starting_feature.attributes.id, "id2": feature.attributes.id}, success : function(d){
					connectWithLine(starting_feature, feature, d);
					resetSelectedFeature();
					starting_feature = null;
				}});
			}
		} else if(tool == "delete"){
			selected_feature = feature;
			deleteSelected();
		}
		else {
			editFeature(feature);
			starting_feature = null;
		}
		
	}
}

function editFeature(feature){
	selected_feature = feature;
	if(active_popup){
		map.removePopup(active_popup.popup);
	}
	$.ajax( { type : "GET", url : "./?pg="+feature.attributes.type+"&action=get&id="+feature.attributes.id, cache : false, success : function(d){
	active_popup = create_Popup(feature, d);
		if(feature.attributes.type=="states")
			setupStateEditor();
		if(feature.attributes.type=="decisions")
			setupDecisionEditor();
		$(".first_input").focus();
	}});
}

function setupStateEditor(){
	$(".state_name input").change(updateState);
	$(".save_state").click(updateState);
}

function setupDecisionEditor(){
	$(".decision_name input").change(updateDecision);
	$(".save_decision").click(updateDecision);
	$("select.decision_type").change(function(){
		var selected_type = $("select.decision_type option:selected").val();
		$(".decision_question").toggle(selected_type == "Input");
		$(".decision_variable").toggle(selected_type == "Variable");
		$(".decision_input_type").toggle(selected_type == "Input");
		$(".decision_store").toggle(selected_type == "Input");
	});
	$("select.decision_type").change();
}

function updateState(){
	$.ajax( { type : "POST", url : "?pg=states&action=upd", cache : false, data: {"id":selected_feature.attributes.id, "name": $(".state_name input").val(), "description": $(".state_description input").val(), "info": $(".state_info input").val(), "document": $(".state_document input").val(), "video_link": $(".state_video_link input").val(), "checked": ($(".decision_start:checked").length>0 ? "checked" : "")}, success : function(d){}});
	if(selected_feature.attributes.record==undefined){
		selected_feature.attributes.record = {};
	}
	selected_feature.attributes.record.name = $(".state_name input").val();
	recalculateStateSize(selected_feature);
	recreateLabel(selected_feature);
	var bounds = selected_feature.geometry.getBounds().toArray();
	$.ajax( { type : "POST", url : "?pg=states&action=move", cache : false, data: {"id":selected_feature.attributes.id, "x":bounds[0], "y":bounds[3] - 40, "w":bounds[2]-bounds[0], "h":bounds[3]-bounds[1]}, success : function(d){}});
}

function recalculateStateSize(feature){
	var size = CanvasTextFunctions.measure(null, 15, feature.attributes.record.name);
	var bounds = feature.geometry.getBounds().toArray();
	var i=0;
	var tmp_geom = new OpenLayers.Bounds(bounds[0], bounds[1], bounds[0] + size + 10, bounds[3]).toGeometry();
	var vs = feature.geometry.getVertices();
	var tvs = tmp_geom.getVertices();
	for ( var i in vs){
		vs[i].move(tvs[i].x - vs[i].x, tvs[i].y - vs[i].y);
	}
	recenterLineEndpoints(feature);
	vector_layer.drawFeature(feature);
}

function recalculateDecisionSize(feature){
	var size = CanvasTextFunctions.measure(null, 15, feature.attributes.record.name);
	var bounds = feature.geometry.getBounds().toArray();
	var i=0;
	var tmp_geom = getDecisionGeometry(bounds[0], bounds[3] - 40, size + 10, 40);
	var vs = feature.geometry.getVertices();
	var tvs = tmp_geom.getVertices();
	for ( var i in vs){
		vs[i].move(tvs[i].x - vs[i].x, tvs[i].y - vs[i].y);
	}
	recenterLineEndpoints(feature);
	vector_layer.drawFeature(feature);
}

function recreateLabel(feature){
	if(feature.text_multiline!=undefined) feature.text_multiline.destroy();
	addLabel(feature);
	centerTextIntoBlock(feature);
}

function getConditionMatrix(){
	var conditions = [];
	$(".decision_condition").each(function(){
		var condition = $(".condition", $(this)).val();
		var outcome = $(".outcome option:selected", $(this)).val();
		conditions.push({"condition":condition, "outcome":outcome});
	});
	return conditions;
}

function updateDecision(){
	$.ajax( { type : "POST", url : "?pg=decisions&action=upd", cache : false, data: {"id":selected_feature.attributes.id, "name": $(".decision_name input").val(), "description": $(".decision_description input").val(), "question": $(".decision_question input").val(), "decision_type":$(".decision_type option:selected").val(), "input_type":$(".decision_input_type option:selected").val(), "checked": ($(".decision_start:checked").length>0 ? "checked" : ""), "conditions":getConditionMatrix()}, success : function(d){}});
	if(selected_feature.attributes.record==undefined){
		selected_feature.attributes.record = {};
	}
	selected_feature.attributes.record.name = $(".decision_name input").val();
	recalculateDecisionSize(selected_feature);
	recreateLabel(selected_feature);
	var bounds = selected_feature.geometry.getBounds().toArray();
	$.ajax( { type : "POST", url : "?pg=decisions&action=move", cache : false, data: {"id":selected_feature.attributes.id, "x":bounds[0], "y":bounds[3] - 40, "w":bounds[2]-bounds[0], "h":bounds[3]-bounds[1]}, success : function(d){}});
}

function connectWithLine(feature1, feature2, id){
	var line = createSimpleLine(getCentroid(feature1), getCentroid(feature2));
	line[0].from = feature1;
	line[0].to = feature2;
	line[0].attributes.id = id;
	feature1.from_lines.push(line[0]);
	feature2.to_lines.push(line[0]);
	connection_layer.addFeatures(line);
}

function featureMoved(feature){
	var bounds = feature.geometry.getBounds().toArray();
	$.ajax( { type : "POST", url : "?pg="+feature.attributes.type+"&action=move", cache : false, data: {"id":feature.attributes.id, "x": bounds[0], "y": bounds[1], "w": bounds[2]-bounds[0], "h": bounds[3]-bounds[1]}});
}

function getCentroid(feature){
	var bs = feature.geometry.getBounds().toArray();
	return new OpenLayers.Geometry.Point(bs[0] + (bs[2]-bs[0])/2, bs[3] + (bs[1]-bs[3]) / 2);
}

function recenterLineEndpoints(feature){
	var centroid = getCentroid(feature);
	for ( var i in feature.from_lines)
	{
		if(feature.from_lines[i].geometry != null){
			var vs = feature.from_lines[i].geometry.getVertices(true);
			vs[0].move(centroid.x - vs[0].x, centroid.y - vs[0].y);
			connection_layer.drawFeature(feature.from_lines[i]);
		}
	}
	for ( var i in feature.to_lines)
	{
		if(feature.to_lines[i].geometry != null){
			var vs = feature.to_lines[i].geometry.getVertices(true);
			vs[vs.length - 1].move(centroid.x - vs[vs.length - 1].x, centroid.y - vs[vs.length - 1].y);	
			connection_layer.drawFeature(feature.to_lines[i]);
		}
	}
}

function featureMove(feature, pix){
	recenterLineEndpoints(feature);
	centerTextIntoBlock(feature);
}

function centerTextIntoBlock(feature){
	if(feature.text_multiline.geometry.getBounds() != null){
		var tmp = feature.geometry.getBounds().toArray();
		if(last_feature_pos!=null && (tmp[0] - last_feature_pos[0]>10 || tmp[3] - last_feature_pos[3])){
			if(active_popup)
				map.removePopup(active_popup.popup);
		}
		var vs = feature.text_multiline.geometry.getVertices();
		var vb = feature.text_multiline.geometry.getBounds().toArray();
		var xdif= tmp[0] - vb[0] + ((tmp[2]-tmp[0]) - (vb[2]-vb[0]))/2;
		var ydif = tmp[3] - vb[3] + ((tmp[1]-tmp[3]) - (vb[1]-vb[3]))/2;
		for ( var i in vs){
			vs[i].move(xdif,ydif);
		}
		last_feature_pos = tmp;
		vector_layer.drawFeature(feature.text_multiline);
	}
}

function map_click(e) {
	var pos = map.getLonLatFromViewPortPx(e.xy);
	if(tool=="state"){
		$.ajax( { type : "POST", url : "?pg=states&action=add", cache : false, data: {"x": pos.lon-60, "y": pos.lat-20, "w": 120, "h": 40}, success : function(d){
			var features = createState(pos.lon-60, pos.lat-20, 120, 40, d);
			vector_layer.addFeatures(features);
			editFeature(features[0]);
		}});
	}
	if(tool=="decision"){
		$.ajax( { type : "POST", url : "?pg=decisions&action=add", cache : false, data: {"x": pos.lon-60, "y": pos.lat-20, "w": 140, "h": 100}, success : function(d){
			var features = createDecision(pos.lon-60, pos.lat-20, 120, 40, d);
			vector_layer.addFeatures(features);
			editFeature(features[0]);
		}});
	}
}

function create_Popup(feature, html) {
	try{
		var box = feature.geometry.getBounds();
		var x = (box.left + box.right)/2;
		var y = (box.top  + box.bottom)/2;
		var theID =  OpenLayers.Util.createUniqueID("fpopup_");
		var theHTML = '';
		theHTML += html;
		var ll  = new OpenLayers.LonLat(x, y);
		var data = {'popupContentHTML' : theHTML,'overflow' : "auto"}
		var f = new OpenLayers.Feature(popup_layer, ll, data);
		f.closeBox = true;
		f.popupClass = MaxSizeAnchoredBubble;
		f.popup = f.createPopup(f.closeBox);
		f.popup.opacity=0.95;
		f.popup.backgroundColor="#BBCCFF";
		map.addPopup(f.popup);
		return(f);
	} catch (ex) {}
}

function addLabel(feature){
	if(feature.attributes.record==undefined) return;
	var objBounds = feature.geometry.getBounds().toArray();
	var line = null;
	if(feature.attributes.type =="states")
		line = CanvasTextFunctions.draw(null, null, 15, objBounds[0], objBounds[3], feature.attributes.record.name);
	else if(feature.attributes.type =="decisions")
		line = CanvasTextFunctions.draw(null, null, 15, objBounds[0]+15, objBounds[3]-35, feature.attributes.record.name);
	line.style={strokeColor: "#000000", strokeOpacity: 1, strokeWidth: 1};	
	feature.text_multiline = line;
	vector_layer.addFeatures(line);
}