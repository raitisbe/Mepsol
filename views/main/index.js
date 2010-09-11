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

$(document).ready(function() {
	var maxExtent = new OpenLayers.Bounds(0, 0, 20037508.34, 20037508.34);
	var EPSG900913 = new OpenLayers.Projection("EPSG:900913");
	map = new OpenLayers.Map('map',	{ maxExtent: maxExtent, numZoomLevels: 22, maxResolution: 200000.0, units: 'm', projection: EPSG900913});
	createControls();
	createLayers();
	createDraggers();
	//map.zoomToMaxExtent();
	map.events.register("click", map, map_click);
	var centerPoint = new OpenLayers.LonLat(0,0);
	map.setCenter(centerPoint, 18);
	$("#tool_select").click(activateSelectors);
	$("#tool_link").click(activateLinker);
	$("#tool_state").click(function(){setTool("state")});
	$("#tool_state").click();
	$("#tool_decision").click(function(){setTool("decision")});
	loadModel();
	$(document).keydown(function(e){
		switch (e.which) {
		case 46:
			if(selected_feature!=null){
				$.ajax( { type : "POST", url : "?pg=states&action=del", cache : false, data: {"id":selected_feature.attributes.id}, success : function(d){
				}});
				selected_feature.destroy();
				vector_layer.redraw();
				selected_feature = null;
			}
			break;
		}
	})
})

function loadModel(){
	$.ajax( { type : "GET", url : "./?pg=states&action=list", cache : false, dataType: "json", success : function(d){
		$(d.states).each(function(){
			vector_layer.addFeatures(createState(this.x, this.y, this.w, this.h, this.id, this));
		});
		addLabels(vector_layer);
	}});
}

function createState(left, top, width, height, id, record){
	var features = [];
	features.push(new OpenLayers.Feature.Vector(new OpenLayers.Bounds(left, top+height, left+width, top).toGeometry()));
	features[0].from_lines = [];
	features[0].to_lines = [];
	features[0].style={fillColor:"#eeeeee", opacity: 1, strokeColor: "#339933", strokeOpacity: 1, strokeWidth: 3};
	features[0].attributes.id = id;
	features[0].attributes.type = "states";
	features[0].attributes.record = record;
	return features;
}

function createDecision(left, top, width, height, id){
	var features = [];
	features.push(new OpenLayers.Feature.Vector(new OpenLayers.Geometry.LinearRing([new OpenLayers.Geometry.Point(left, top+height/2), new OpenLayers.Geometry.Point(left+width/2, top+height), new OpenLayers.Geometry.Point(left+width, top+height/2), new OpenLayers.Geometry.Point(left+width/2, top)])));
	features[0].from_lines = [];
	features[0].to_lines = [];
	features[0].style={fillColor:"#eeeeee", opacity: 1, strokeColor: "#339933", strokeOpacity: 1, strokeWidth: 3};
	features[0].attributes.type = "decisions";
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
	ctrlDragState = new OpenLayers.Control.DragFeature(vector_layer);
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
	$("#tool_"+tool).removeClass("selected");
	tool = which;
	$("#tool_"+which).addClass("selected");
}

function featureSelected(feature){
	last_feature_pos = feature.geometry.getBounds().toArray();
	if(linking){
		if(starting_feature==null){
			starting_feature = feature;
		} else {
			connectWithLine(starting_feature, feature);
			linking = false;
		}
	} else {
		selected_feature = feature;
		if(active_popup)
			map.removePopup(active_popup.popup);
		var cur_feature_type = feature.attributes.type;
		$.ajax( { type : "GET", url : "./?pg="+cur_feature_type+"&action=get&id="+feature.attributes.id, cache : false, success : function(d){
			active_popup = create_Popup(feature, d);
			setupStateEditor();
		}});
	}
}

function setupStateEditor(){
	$(".name").change(updateState)
}

function updateState(){
	$.ajax( { type : "POST", url : "?pg=states&action=upd", cache : false, data: {"id":selected_feature.attributes.id, "name": $(".name").val()}, success : function(d){
	
	}});
}

function connectWithLine(feature1, feature2){
	var line = createSimpleLine(feature1.geometry.getCentroid(), feature2.geometry.getCentroid());
	line[0].from = feature1;
	line[0].to = feature2;
	feature1.from_lines.push(line[0]);
	feature2.to_lines.push(line[0]);
	connection_layer.addFeatures(line);
}

function featureMoved(feature){
	var bounds = feature.geometry.getBounds().toArray();
	$.ajax( { type : "POST", url : "?pg="+feature.attributes.type+"&action=move", cache : false, data: {"id":feature.attributes.id, "x": bounds[0], "y": bounds[1], "w": bounds[2]-bounds[0], "h": bounds[3]-bounds[1]}});
}

var last_feature_pos = null;

function featureMove(feature, pix){
	var  centroid = feature.geometry.getCentroid();
	for ( var i in feature.from_lines)
	{
		var vs = feature.from_lines[i].geometry.getVertices(true);
		vs[0].move(centroid.x - vs[0].x, centroid.y - vs[0].y);
	}
	for ( var i in feature.to_lines)
	{
		var vs = feature.to_lines[i].geometry.getVertices(true);
		vs[vs.length - 1].move(centroid.x - vs[vs.length - 1].x, centroid.y - vs[vs.length - 1].y);
	}
	if(last_feature_pos != null){
		var tmp = feature.geometry.getBounds().toArray();
		if(tmp[0] - last_feature_pos[0]>10 || tmp[3] - last_feature_pos[3]){
			if(active_popup)
				map.removePopup(active_popup.popup);
		}
		var vs = feature.text_multiline.geometry.getVertices();
		for ( var i in vs){
			vs[i].move(tmp[0] - last_feature_pos[0], tmp[3] - last_feature_pos[3]);
		}
		vector_layer.redraw();
	}
	connection_layer.redraw();
	last_feature_pos = feature.geometry.getBounds().toArray();
}

function map_click(e) {
	var pos = map.getLonLatFromViewPortPx(e.xy);
	if(tool=="state"){
		$.ajax( { type : "POST", url : "?pg=states&action=add", cache : false, data: {"x": pos.lon-60, "y": pos.lat-20, "w": 120, "h": 40}, success : function(d){
			vector_layer.addFeatures(createState(pos.lon-60, pos.lat-20, 120, 40, d));;
		}});
	}
	if(tool=="decision"){
		vector_layer.addFeatures(createDecision(pos.lon-60, pos.lat-20, 140, 100));
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
		f.closeBox = false;
		f.popupClass = MaxSizeAnchoredBubble;
		f.popup = f.createPopup(f.closeBox);
		f.popup.opacity=0.95;
		f.popup.backgroundColor="#BBCCFF";
		map.addPopup(f.popup);
		return(f);
	} catch (ex) {}
}


function addLabels(layer){
    for(var i in layer.features)
    {
        var objBounds = layer.features[i].geometry.getBounds().toArray();
	var line = CanvasTextFunctions.draw(null, null, 15, objBounds[0],objBounds[3], layer.features[i].attributes.record.name);
	line.style={strokeColor: "#000000", strokeOpacity: 1, strokeWidth: 2};
	vector_layer.addFeatures(line);
	layer.features[i].text_multiline = line;
    }
}
