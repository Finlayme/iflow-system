define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'webhook/record/index' + location.search,
                    view_url: 'webhook/record/show',
                    table: 'webhook_record'
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'type', title: __('Type')},
                        {field: 'status', title: __('Status'), searchList: {"0":__('Status 0'),"1":__('Status 1')}, formatter: Table.api.formatter.status},
                        {
                            field: 'buttons',
                            width: "120px",
                            title: __('Record'),
                            table: table,
                            events: Table.api.events.operate,
                            buttons: [
                                {
                                    name: 'addtabs',
                                    text: __('Request data'),
                                    title: __('Request data'),
                                    classname: 'btn btn-xs btn-info btn-detail btn-dialog',
                                    icon: 'fa fa-list',
                                    url: $.fn.bootstrapTable.defaults.extend.view_url + '?type=request&'
                                },
                                {
                                    name: 'addtabs',
                                    text: __('Header data'),
                                    title: __('Header data'),
                                    classname: 'btn btn-xs btn-info btn-detail btn-dialog',
                                    icon: 'fa fa-list',
                                    url: $.fn.bootstrapTable.defaults.extend.view_url + '?type=header&'
                                },
                                {
                                    name: 'addtabs',
                                    text: __('Response data'),
                                    title: __('Response data'),
                                    classname: 'btn btn-xs btn-info btn-detail btn-dialog',
                                    icon: 'fa fa-list',
                                    url: $.fn.bootstrapTable.defaults.extend.view_url + '?type=response&'
                                }
                            ],
                            formatter: Table.api.formatter.buttons
                        },
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});