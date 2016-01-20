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
         // training.js

               root = d3.json(this.chartDataUrl, function(error, root) {
                 if (error) throw error;

                 var margin = {top: 20, right: 120, bottom: 20, left:100},
                     width = 950 - margin.right - margin.left,
                     height = 800 - margin.top - margin.bottom;

                 var i = 0,
                     duration = 750;
                 var tree = d3.layout.tree()
                     .size([height, width]);

                 var diagonal = d3.svg.diagonal()
                     .projection(function(d) { return [d.y, d.x]; });

                 var svg = d3.select("#tree").append("svg")
                     .attr("width", width + margin.right + margin.left)
                     .attr("height", height + margin.top + margin.bottom)
                   .append("g")
                     .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

                 //root = treeData[0];
                 root.x0 = height / 2;
                 root.y0 = 0;

                 update(root);

                 d3.select(self.frameElement).style("height", "800px");

                 function update(source) {

                   // Compute the new tree layout.
                   var nodes = tree.nodes(root).reverse(),
                       links = tree.links(nodes);

                   // Normalize for fixed-depth.
                   nodes.forEach(function(d) { d.y = d.depth * 180; });

                   // Update the nodesโ€ฆ
                   var node = svg.selectAll("g.node")
                       .data(nodes, function(d) { return d.id || (d.id = ++i); });

                   // Enter any new nodes at the parent's previous position.
                   var nodeEnter = node.enter().append("g")
                       .attr("class", "node")
                       .attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; })
                       .on("click", click);

                   nodeEnter.append("circle")
                       .attr("r", 1e-6)
                       .style("fill", function(d) { return d._children ? "#ccff99" : "#fff"; });

                   nodeEnter.append("text")
                       .attr("x", function(d) { return d.children || d._children ? -13 : 13; })
                       .attr("dy", ".35em")
                       .attr("text-anchor", function(d) { return d.children || d._children ? "end" : "start"; })
                       .text(function(d) { return d.name; })
                       .style("fill-opacity", 1e-6)
                      .attr("class", function(d) {
                               if (d.url != null) { return 'hyper'; }
                          })
                           .on("click", function (d) {
                               $('.hyper').attr('style', 'font-weight:normal');
                               d3.select(this).attr('style', 'font-weight:bold');
                               if (d.url != null) {
                                  //  window.location=d.url;
                                  $('#vid').remove();

                                  $('#vid-container').append( $('<embed>')
                                     .attr('id', 'vid')
                                     .attr('src', d.url + "?version=3&amp;hl=en_US&amp;rel=0&amp;autohide=1&amp;autoplay=1")
                                     .attr('wmode',"transparent")
                                     .attr('type',"application/x-shockwave-flash")
                                     .attr('width',"100%")
                                     .attr('height',"100%")
                                     .attr('allowfullscreen',"true")
                                     .attr('title',d.name)
                                   )
                                 }
                           })
                     ;

                   // Transition nodes to their new position.
                   var nodeUpdate = node.transition()
                       .duration(duration)
                       .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; });

                   nodeUpdate.select("circle")
                       .attr("r", 10)
                       .style("fill", function(d) { return d._children ? "#ccff99" : "#fff"; });

                   nodeUpdate.select("text")
                       .style("fill-opacity", 1);

                   // Transition exiting nodes to the parent's new position.
                   var nodeExit = node.exit().transition()
                       .duration(duration)
                       .attr("transform", function(d) { return "translate(" + source.y + "," + source.x + ")"; })
                       .remove();

                   nodeExit.select("circle")
                       .attr("r", 1e-6);

                   nodeExit.select("text")
                       .style("fill-opacity", 1e-6);

                   // Update the linksโ€ฆ
                   var link = svg.selectAll("path.link")
                       .data(links, function(d) { return d.target.id; });

                   // Enter any new links at the parent's previous position.
                   link.enter().insert("path", "g")
                       .attr("class", "link")
                       .attr("d", function(d) {
                         var o = {x: source.x0, y: source.y0};
                         return diagonal({source: o, target: o});
                       });

                   // Transition links to their new position.
                   link.transition()
                       .duration(duration)
                       .attr("d", diagonal);

                   // Transition exiting nodes to the parent's new position.
                   link.exit().transition()
                       .duration(duration)
                       .attr("d", function(d) {
                         var o = {x: source.x, y: source.y};
                         return diagonal({source: o, target: o});
                       })
                       .remove();

                   // Stash the old positions for transition.
                   nodes.forEach(function(d) {
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
               });

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
