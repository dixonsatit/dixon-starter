 yii.rbac = (function($) {
    var pub = {
       chartDataUrl: undefined,
       userId: undefined,
       listAssigndUrl: undefined,
       listAvailableUrl: undefined,
       assignUrl: undefined,
       revokeUrl: undefined,
       isActive: true,
       init: function() {

       },
       renderChart: function($selector){


         var margin = {
     top: 20,
     right: 120,
     bottom: 20,
     left: 120
 },
 width = 960 - margin.right - margin.left,
 height = 800 - margin.top - margin.bottom;

 var root = {
	"name": "RBAC",
	"children": [{
		"name": "analytics"
	},{
		"name": "analytics"
	},{
		"name": "analytics"
	},{
		"name": "analytics"
	}]
};

 var i = 0,
     duration = 750,
     rectW = 60,
     rectH = 30;

 var tree = d3.layout.tree().nodeSize([70, 40]);
 var diagonal = d3.svg.diagonal()
     .projection(function (d) {
     return [d.x + rectW / 2, d.y + rectH / 2];
 });

 var svg = d3.select("#body").append("svg").attr("width", 1000).attr("height", 1000)
     .call(zm = d3.behavior.zoom().scaleExtent([1,3]).on("zoom", redraw)).append("g")
     .attr("transform", "translate(" + 350 + "," + 20 + ")");

 //necessary so that zoom knows where to zoom and unzoom from
 zm.translate([350, 20]);

 root.x0 = 0;
 root.y0 = height / 2;

 function collapse(d) {
     if (d.children) {
         d._children = d.children;
         d._children.forEach(collapse);
         d.children = null;
     }
 }

 root.children.forEach(collapse);
 update(root);

 d3.select("#body").style("height", "800px");

 function update(source) {

     // Compute the new tree layout.
     var nodes = tree.nodes(root).reverse(),
         links = tree.links(nodes);

     // Normalize for fixed-depth.
     nodes.forEach(function (d) {
         d.y = d.depth * 180;
     });

     // Update the nodes…
     var node = svg.selectAll("g.node")
         .data(nodes, function (d) {
         return d.id || (d.id = ++i);
     });

     // Enter any new nodes at the parent's previous position.
     var nodeEnter = node.enter().append("g")
         .attr("class", "node")
         .attr("transform", function (d) {
         return "translate(" + source.x0 + "," + source.y0 + ")";
     })
         .on("click", click);

     nodeEnter.append("rect")
         .attr("width", rectW)
         .attr("height", rectH)
         .attr("stroke", "black")
         .attr("stroke-width", 1)
         .style("fill", function (d) {
         return d._children ? "lightsteelblue" : "#fff";
     });

     nodeEnter.append("text")
         .attr("x", rectW / 2)
         .attr("y", rectH / 2)
         .attr("dy", ".35em")
         .attr("text-anchor", "middle")
         .text(function (d) {
         return d.name;
     });

     // Transition nodes to their new position.
     var nodeUpdate = node.transition()
         .duration(duration)
         .attr("transform", function (d) {
         return "translate(" + d.x + "," + d.y + ")";
     });

     nodeUpdate.select("rect")
         .attr("width", rectW)
         .attr("height", rectH)
         .attr("stroke", "black")
         .attr("stroke-width", 1)
         .style("fill", function (d) {
         return d._children ? "lightsteelblue" : "#fff";
     });

     nodeUpdate.select("text")
         .style("fill-opacity", 1);

     // Transition exiting nodes to the parent's new position.
     var nodeExit = node.exit().transition()
         .duration(duration)
         .attr("transform", function (d) {
         return "translate(" + source.x + "," + source.y + ")";
     })
         .remove();

     nodeExit.select("rect")
         .attr("width", rectW)
         .attr("height", rectH)
     //.attr("width", bbox.getBBox().width)""
     //.attr("height", bbox.getBBox().height)
     .attr("stroke", "black")
         .attr("stroke-width", 1);

     nodeExit.select("text");

     // Update the links…
     var link = svg.selectAll("path.link")
         .data(links, function (d) {
         return d.target.id;
     });

     // Enter any new links at the parent's previous position.
     link.enter().insert("path", "g")
         .attr("class", "link")
         .attr("x", rectW / 2)
         .attr("y", rectH / 2)
         .attr("d", function (d) {
         var o = {
             x: source.x0,
             y: source.y0
         };
         return diagonal({
             source: o,
             target: o
         });
     });

     // Transition links to their new position.
     link.transition()
         .duration(duration)
         .attr("d", diagonal);

     // Transition exiting nodes to the parent's new position.
     link.exit().transition()
         .duration(duration)
         .attr("d", function (d) {
         var o = {
             x: source.x,
             y: source.y
         };
         return diagonal({
             source: o,
             target: o
         });
     })
         .remove();

     // Stash the old positions for transition.
     nodes.forEach(function (d) {
         d.x0 = d.x;
         d.y0 = d.y;
     });
 }

 // Toggle children on click.
 function click(d) {
     if (d.children) {
         d._children = d.children;
         d.children = null;
     } else {
         d.children = d._children;
         d._children = null;
     }
     update(d);
 }

 function redraw() {
   //console.log("here", d3.event.translate, d3.event.scale);
   svg.attr("transform",
       "translate(" + d3.event.translate + ")"
       + " scale(" + d3.event.scale + ")");
 }

       },
       listAssignd: function($term,$selector){
          pub.listData(pub.listAssigndUrl,$selector,$term,{id:pub.userId,trem:$term});
       },
       listAvailable: function($term,$selector){
          pub.listData(pub.listAvailableUrl,$selector,$term,{id:pub.userId,trem:$term});
       },
       listData: function($url, $selector, $term, $params){
         $.get($url, $params ,function(result){
             var $list = $($selector);
             $list.html('');
             if (result.Roles) {
                 var $group = $('<optgroup label="Roles">');
                 $.each(result.Roles, function () {
                     $('<option>').val(this).text(this).appendTo($group);
                 });
                 $group.appendTo($list);
             }
             if (result.Permissions) {
                 var $group = $('<optgroup label="Permissions">');
                 $.each(result.Permissions, function () {
                     $('<option>').val(this).text(this).appendTo($group);
                 });
                 $group.appendTo($list);
             }
             if (result.Routes) {
                 var $group = $('<optgroup label="Routes">');
                 $.each(result.Routes, function () {
                     $('<option>').val(this).text(this).appendTo($group);
                 });
                 $group.appendTo($list);
             }
         });
       },
       assigned: function(roleName,callback){
         $.post(pub.assignUrl, {
           userId: pub.userId,
           roleName: roleName
         },function(result){
            callback(result);
         });
       },
       revoke: function(roleName,callback){
         $.post(pub.revokeUrl, {
           userId: pub.userId,
           roleName: roleName
         },function(result){
              callback(result);
         });
       },
       initAssignment: function(properties,$assignedId,$availableId){
         pub.initProperties(properties);
         yii.rbac.listAssignd('',$assignedId);
         yii.rbac.listAvailable('',$availableId);
         $('#btn-assign').click(function(e){
           var selected = $($availableId).val();
           if(selected != null){
             pub.assigned(selected,function(result){
               yii.rbac.listAssignd('',$assignedId);
               yii.rbac.listAvailable('',$availableId);
             });
           }
           event.preventDefault();
         });

         $('#btn-assign-all').click(function(e){
           $($availableId+' option').prop('selected', true);
           $('#btn-assign').trigger('click');
           event.preventDefault();
         });

         $('#btn-revoke').click(function(e){
           var selected = $($assignedId).val();
           if(selected != null){
             pub.revoke(selected,function(result){
               console.log(result);
               yii.rbac.listAssignd('',$assignedId);
               yii.rbac.listAvailable('',$availableId);
             });
           }
           event.preventDefault();
         });

         $('#btn-revoke-all').click(function(e){
           $($assignedId+' option').prop('selected', true);
           $('#btn-revoke').trigger('click');
           event.preventDefault();
         });
       },
       initProperties: function (properties) {
            $.each(properties, function (key, val) {
                pub[key] = val;
            });
        },
    };

    return pub;
 })(jQuery);
