(function (Icinga) {
    var StatusMap = function (module) {
        /**
         * The Icinga.Module instance
         */
        this.module = module;

        this.initialize();
    };

    StatusMap.prototype = {
        initialize: function () {
            this.module.on('rendered', this.createGraph);
            this.module.icinga.logger.debug('StatusMap module loaded');
        },

        createGraph: function () {
            var container = $('#yolocontainer');
            var hosts_data = container.data('hosts');
            var dependency_data = container.data('dependencies');

            var node_data = [];
            for (var i in hosts_data) {
                host = hosts_data[i];
                node_data.push({
                    id: host.host_name,
                    label: host.display_name,
                    color: this.stateToColor(host.state),
                    font: {
                        color: "#ffffff",
                    },
                });
            }
            // create an array with nodes
            var nodes = new vis.DataSet(node_data);

            var edge_data = [];
            for (var i in dependency_data) {
                dependency = dependency_data[i];
                edge_data.push({
                    from: dependency.parent,
                    to: dependency.child
                });
            }

            // create an array with edges
            var edges = new vis.DataSet(edge_data);

            // create a network
            var data = {
                nodes: nodes,
                edges: edges,
            };
            var options = {};
            var network = new vis.Network(container.get(0), data, options);
        },

        stateToColor: function (state) {
            switch (state) {
                case 0:
                    return '#44bb77'; // UP
                case 1:
                    return '#ff5566'; // DOWN
                case 2:
                    return '#aa44ff'; // UNREACHABLE
                case 99:
                    return '#77aaff'; // PENDING
            }
            return '#0095BF'; // icinga-blue
        },
    }

    Icinga.availableModules.statusmap = StatusMap;

}(Icinga));
