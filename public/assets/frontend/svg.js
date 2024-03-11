function makeSVGElement(tag, attrs) {
    var el = document.createElementNS('http://www.w3.org/2000/svg', tag);
    for (var k in attrs) {
        el.setAttribute(k, attrs[k]);
    }
    return el;
}

function svg_gen() {

    var svg = document.querySelectorAll('[data-dash]');
    var lang_ = "ltr";
    svg.forEach(function (svg_item) {
        //e.firstElementChild can be used.
        var child = svg_item.lastElementChild;
        while (child) {
            svg_item.removeChild(child);
            child = svg_item.lastElementChild;
        }

        //dimension of svg

        var svgRect = svg_item.getBoundingClientRect();
        var svgw = svgRect.width;
        var svgh = svgRect.height;
        var color = (svg_item.dataset.color !== undefined) ? svg_item.dataset.color : '#FFF';

        if (svg_item.dataset.top !== undefined) {
            var path = makeSVGElement('path', {
                d: 'M ' + [0, 1] + ' h' + svgw,
                stroke: color,
                'stroke-width': 2,
                class: 'dash_anim pos_top',
                'stroke-dasharray': 5
            });
            svg_item.appendChild(path);
        }
        if (lang_ == 'rtl' && svg_item.dataset.right !== undefined) {
            var path = makeSVGElement('path', {
                d: 'M ' + [(svgw - 11), (svgw - 12)] + ' h ' + svgh,
                stroke: color,
                'stroke-width': 2,
                transform: 'rotate(90,' + [(svgw - 11), 0] + ')',
                class: 'dash_anim line_r pos_left',
                'stroke-dasharray': 5
            });
            svg_item.appendChild(path);
        } else if (svg_item.dataset.right !== undefined) {
            var path = makeSVGElement('path', {
                d: 'M ' + [(svgw - 0), 0] + ' h ' + svgh,
                stroke: color,
                'stroke-width': 2,
                transform: 'rotate(90,' + [(svgw - 1), 0] + ')',
                class: 'dash_anim pos_right',
                'stroke-dasharray': 5
            });
            svg_item.appendChild(path);
        }
        if (lang_ == 'rtl' && svg_item.dataset.left !== undefined) {
            var path = makeSVGElement('path', {
                d: 'M ' + [(svgw - 0), 0] + ' h ' + svgh,
                stroke: color,
                'stroke-width': 2,
                transform: 'rotate(90,' + [(svgw - 1), 0] + ')',
                class: 'dash_anim pos_right',
                'stroke-dasharray': 5
            });
            svg_item.appendChild(path);
        } else if (svg_item.dataset.left !== undefined) {
            var path = makeSVGElement('path', {
                d: 'M ' + [(svgw - 11), (svgw - 12)] + ' h ' + svgh,
                stroke: color,
                'stroke-width': 2,
                transform: 'rotate(90,' + [(svgw - 11), 0] + ')',
                class: 'dash_anim line_r pos_left',
                'stroke-dasharray': 5
            });
            svg_item.appendChild(path);
        }

        if (svg_item.dataset.bottom !== undefined) {
            var path = makeSVGElement('path', {
                d: 'M ' + [0, (svgh - 1)] + ' h' + svgw,
                stroke: color,
                'stroke-width': 2,
                class: 'dash_anim line_r pos_bottom',
                'stroke-dasharray': 5
            });
            svg_item.appendChild(path);
        }

    });



}
window.addEventListener('load', function (event) {
    svg_gen();
});
window.addEventListener('resize', function (event) {
    svg_gen();
}, true);