require.config({
    paths: {
        'flow': '../addons/flow/js/require-flow',
        'jsplumb': '../addons/flow/js/jsplumb/jsplumb.min',
        'chart': '../addons/flow/js/jsplumb/chart',
        'vue': '../addons/flow/js/form/vue.min',
        'formdesign': '../addons/flow/js/form/k-form-design.umd.min',
    },
    shim: {
        'chart': ['css!../addons/flow/js/jsplumb/chart.css'],
        'formdesign': ['css!../addons/flow/js/form/k-form-design.css']
    }
});
