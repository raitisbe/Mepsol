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
	createLayers();
	//map.zoomToMaxExtent();
	var centerPoint = new OpenLayers.LonLat(10000000,10000000);
	map.setCenter(centerPoint, 18);
	$("#next").click(goToNext);
	$("#previous").click(goToPrev);
	$("#accordion").accordion({ header: "h3"});
	loadModel();
	startDialog();
})

function getAnswer(){
	if($(".answers").length>0)
		return $(".answers option:selected").val();
	return null;
}

function goToNext(){
	$.ajax( { type : "GET", url : "./?pg=dialog&action=advance", cache : false, data: {"answer":getAnswer()}, dataType: "json", success : function(d){
		receiveState(d);
	}})
}

function goToPrev(){
	$.ajax( { type : "GET", url : "./?pg=dialog&action=step_back", cache : false, dataType: "json", success : function(d){
		receiveState(d);
	}})
}

function startDialog(){
	$.ajax( { type : "GET", url : "./?pg=dialog&action=start", cache : false, dataType: "json", success : function(d){
		if(d.state.length==0){
			alert("Starting state of the dialog has not been set");
			return;
		}
		receiveState(d);
	}})
}

function receiveState(d){
	$("#question_container").html("");
	var state = d.state[0];
	$("#question_container").append("<span class='state_name'>"+state.name+"</span>");
	
	if(state["type"]=="d"){
		if(state.decision_type=="Input"){
			$("#question_container").append("<div class='question'>"+state.question+"</div>");
			if(state.input_type=="DropDown"){
				var tmp = "";
				for(i in d.answers){
					tmp = tmp + "<option value='" + d.answers[i].expr+"'>" + d.answers[i].expr + "</option>";
				}
				$("#question_container").append("<select class='answers'>"+tmp+"</select>");
			}
		}
	}
	$("#video_container, #document_container, #information_container").html("");
	$("#video_cnt, #document_cnt, #info_cnt").html("");
	for(i in d.video_links){
		if(d.video_links[i]!=""){
			$("#video_container").append("<a href='"+d.video_links[i]+"'>"+d.video_links[i]+"</a><br/>");
			$("#video_cnt").html(parseInt($("#video_cnt").html()==""?0:$("#video_cnt").html())+1);
		}
	}
	for(i in d.documents){
		if(d.documents[i]!=""){
			$("#document_container").append("<a href='"+d.documents[i]+"'>"+d.documents[i]+"</a><br/>");
			$("#document_cnt").html(parseInt($("#document_cnt").html()==""?0:$("#document_cnt").html())+1);
		}
	}
	for(i in d.info){
		if(d.info[i]!=""){
			$("#information_container").append("<a href='"+d.info[i]+"'>"+d.info[i]+"</a><br/>");
			$("#info_cnt").html(parseInt($("#info_cnt").html()==""?0:$("#info_cnt").html())+1);
		}
	}
	$("#accordion").accordion('resize');
	setCenterToBlock(state.id);
}

var dest_center = null;

function setCenterToBlock(id){
	for(i in vector_layer.features){
		if(parseInt(vector_layer.features[i].attributes.id)==parseInt(id)){
			dest_center = vector_layer.features[i].geometry.getBounds().getCenterLonLat();
			animateCentering();
			break;
		}
	}
}

function animateCentering(){
	var cur_center = map.getCenter();
	if(Math.sqrt(Math.pow(cur_center.lon-dest_center.lon, 2) + Math.pow(cur_center.lat-dest_center.lat, 2))<3) dest_center = null;
	if(dest_center==null) return;
	map.setCenter(new OpenLayers.LonLat(cur_center.lon + (dest_center.lon - cur_center.lon)/2, cur_center.lat + (dest_center.lat - cur_center.lat)/2));
	setTimeout("animateCentering()", 100);
}

function getCurrentState(){
	$.ajax( { type : "GET", url : "./?pg=dialog&action=get_current", cache : false, dataType: "json", success : function(d){
		receiveState(d);
	}
	})
}

function loadModel(){
	$.ajax( { type : "GET", url : "./?pg=service&action=list_contents", cache : false, dataType: "json", success : function(d){
		$(d[0].states).each(function(){
			vector_layer.addFeatures(createState(this.x, this.y, this.w, this.h, this.id, this));
		});
		$(d[1].decisions).each(function(){
			vector_layer.addFeatures(createDecision(this.x, this.y, this.w, this.h, this.id, this));
		});
		$(d[2].connections).each(function(){
			for(var i in vector_layer.features){
				if(vector_layer.features[i].attributes.id==this.id1){
					for(var ii in vector_layer.features){
						if(vector_layer.features[ii].attributes.id==this.id2){
							connectWithLine(vector_layer.features[i], vector_layer.features[ii]);
						}
					}
				}
			}
		});
		addLabels(vector_layer);
		map.zoomToExtent(vector_layer.getDataExtent(), true);
	}});
}

function createState(left, top, width, height, id, record){
	var features = [];
	features.push(new OpenLayers.Feature.Vector(new OpenLayers.Bounds(left, top+height, left+width, top).toGeometry()));
	features[0].from_lines = [];
	features[0].to_lines = [];
	features[0].style={fillColor:"#eeeeee", opacity: 1, strokeColor: "#339933", strokeOpacity: 1, strokeWidth: 3};
	features[0].attributes={id: id, "type" : "states", record : record};
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
	features.push(new OpenLayers.Feature.Vector(getDecisionGeometry(left, top, width, height), {id: id, "type" : "decisions", record : record}, {fillColor:"#eeeeee", opacity: 1, strokeColor: "#339933", strokeOpacity: 1, strokeWidth: 3}));
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

function connectWithLine(feature1, feature2){
	var line = createSimpleLine(feature1.geometry.getCentroid(), feature2.geometry.getCentroid());
	line[0].from = feature1;
	line[0].to = feature2;
	feature1.from_lines.push(line[0]);
	feature2.to_lines.push(line[0]);
	connection_layer.addFeatures(line);
}

function addLabels(layer){
	for(var i in layer.features)
	{
		addLabel(layer.features[i]);
		centerTextIntoBlock(layer.features[i]);
	}
}

function addLabel(feature){
	var objBounds = feature.geometry.getBounds().toArray();
	var line = null;
	if(feature.attributes.type =="states")
		line = CanvasTextFunctions.draw(null, null, 15, objBounds[0], objBounds[3], feature.attributes.record.name);
	else if(feature.attributes.type =="decisions")
		line = CanvasTextFunctions.draw(null, null, 15, objBounds[0]+15, objBounds[3]-35, feature.attributes.record.name);
	line.style={strokeColor: "#000000", strokeOpacity: 1, strokeWidth: 1};
	vector_layer.addFeatures(line);
	feature.text_multiline = line;
}

function centerTextIntoBlock(feature){
	if(feature.text_multiline.geometry.getBounds() != null){
		var tmp = feature.geometry.getBounds().toArray();
		var vs = feature.text_multiline.geometry.getVertices();
		var vb = feature.text_multiline.geometry.getBounds().toArray();
		var xdif= tmp[0] - vb[0] + ((tmp[2]-tmp[0]) - (vb[2]-vb[0]))/2;
		var ydif = tmp[3] - vb[3] + ((tmp[1]-tmp[3]) - (vb[1]-vb[3]))/2;
		for ( var i in vs){
			vs[i].move(xdif,ydif);
		}
		last_feature_pos = tmp;
		vector_layer.redraw();
	}
}
