export default {
    data() {
        // return data;
        return {
            showstore: false,
            showproduct: false,
            showstatus: false,
            showunit: false,
            showdesc: false,
            showdate: false,
            showoperation: false,

            type_report: 0,
            from_date: "2021-11-24",
            to_date: new Date().toISOString().substr(0, 10),
        };
    },
    methods: {
        report_style(printme, name) {
            var printContents = document.getElementById(printme).innerHTML;

            console.log("ddddddddd", printContents);

            var a = window.open("", "", "height=1000, width=1000");
            a.document.write('<html dir="rtl">');
            a.document.write(
                `<head><title> Valex -  Premium dashboard ui bootstrap rwd admin html5 template </title><link href="{{URL::asset("assets/css/custom-search.css")}}" rel="stylesheet">  <link href="{{URL::asset("assets/css/font-awesome.min.css")}}" rel="stylesheet"><link rel="stylesheet" href="{{URL::asset("assets/css/jstree.css")}}" ><link href="{{URL::asset("assets/css/jquery-ui.min.css")}}" rel="stylesheet"<link rel="icon" href="{{URL::asset("assets/img/brand/favicon.png")}}" type="image/x-icon"/><link href="{{URL::asset("assets/css/icons.css")}}" rel="stylesheet"><link href="{{URL::asset("assets/css/estilos_factura.css")}}" rel="stylesheet"><link href="{{URL::asset("assets/plugins/mscrollbar/jquery.mCustomScrollbar.css")}}" rel="stylesheet"/<link href="{{URL::asset("assets/plugins/sidebar/sidebar.css")}}" rel="stylesheet">                   <link rel="stylesheet" href="{{URL::asset("assets/css-rtl/sidemenu.css")}}"<link href="{{URL::asset("assets/css-rtl/style.css")}}" rel="stylesheet"><link href="{{URL::asset("assets/css-rtl/style-dark.css")}}" rel="stylesheet"><link href="{{URL::asset("assets/css-rtl/skin-modes.css")}}" rel="stylesheet"><link href="{{URL::asset("assets/css/style copy.css")}}" rel="stylesheet"></head>`
            );

            a.document.write("<body>");
            a.document.write(printContents);
            a.document.write("</body></html>");
            a.document.close();
            a.print();
        },
    },
};
