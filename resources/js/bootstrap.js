window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
import G6 from '@antv/g6';
const mynodes = JSON.parse($('#mynodes').val());
    console.log(mynodes);
    const graph = new G6.Graph({
        container: 'mountNode', // String | HTMLElement, required, the id of DOM element or an HTML node
        width: 500, // Number, required, the width of the graph
        height: 500, // Number, required, the height of the graph
        // linkCenter: true,
        layout: {
            type: 'dendrogram',
            direction: 'TB', // H / V / LR / RL / TB / BT
            nodeSep: 40,
            rankSep: 100,
        },

        // graph.node(function(node) {
        // let position = 'right';
        // let rotate = 0;
        // if (!node.children) {
        //     position = 'bottom';
        //     rotate = Math.PI / 2;
        // }
        // return {
        //     label: node.id,
        //     labelCfg: {
        //     position,
        //     offset: 5,
        //     style: {
        //         rotate,
        //         textAlign: 'start',
        //     },
        //     },
        // };

        });


    graph.data(mynodes); // Load the data defined in Step 2
    graph.render(); // Render the graph
    // graph.fitView();
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
