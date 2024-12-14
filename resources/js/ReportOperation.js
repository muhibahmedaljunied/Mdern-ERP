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

    //         a.document.write(`<style>
    // #invoice{
    //     padding: 30px;
    // }

    // .invoice {
    //     position: relative;
    //     background-color: #FFF;
    //     min-height: 680px;
    //     padding: 15px
    // }

    // .invoice header {
    //     padding: 10px 0;
    //     margin-bottom: 20px;
    //     border-bottom: 1px solid #3989c6
    // }

    // .invoice .company-details {
    //     text-align: right
    // }

    // .invoice .company-details .name {
    //     margin-top: 0;
    //     margin-bottom: 0
    // }

    // .invoice .contacts {
    //     margin-bottom: 20px
    // }

    // .invoice .invoice-to {
    //     text-align: left
    // }

    // .invoice .invoice-to .to {
    //     margin-top: 0;
    //     margin-bottom: 0
    // }

    // .invoice .invoice-details {
    //     text-align: right
    // }

    // .invoice .invoice-details .invoice-id {
    //     margin-top: 0;
    //     color: #3989c6
    // }

    // .invoice main {
    //     padding-bottom: 50px
    // }

    // .invoice main .thanks {
    //     margin-top: -100px;
    //     font-size: 2em;
    //     margin-bottom: 50px
    // }

    // .invoice main .notices {
    //     padding-left: 6px;
    //     border-left: 6px solid #3989c6
    // }

    // .invoice main .notices .notice {
    //     font-size: 1.2em
    // }

    // .invoice table {
    //     width: 100%;
    //     border-collapse: collapse;
    //     border-spacing: 0;
    //     margin-bottom: 20px
    // }

    // .invoice table td,.invoice table th {
    //     padding: 15px;
    //     background: #eee;
    //     border-bottom: 1px solid #fff
    // }

    // .invoice table th {
    //     white-space: nowrap;
    //     font-weight: 400;
    //     font-size: 16px
    // }

    // .invoice table td h3 {
    //     margin: 0;
    //     font-weight: 400;
    //     color: #3989c6;
    //     font-size: 1.2em
    // }

    // .invoice table .qty,.invoice table .total,.invoice table .unit {
    //     text-align: right;
    //     font-size: 1.2em
    // }

    // .invoice table .no {
    //     color: #fff;
    //     font-size: 1.6em;
    //     background: #3989c6
    // }

    // .invoice table .unit {
    //     background: #ddd
    // }

    // .invoice table .total {
    //     background: #3989c6;
    //     color: #fff
    // }

    // .invoice table tbody tr:last-child td {
    //     border: none
    // }

    // .invoice table tfoot td {
    //     background: 0 0;
    //     border-bottom: none;
    //     white-space: nowrap;
    //     text-align: right;
    //     padding: 10px 20px;
    //     font-size: 1.2em;
    //     border-top: 1px solid #aaa
    // }

    // .invoice table tfoot tr:first-child td {
    //     border-top: none
    // }

    // .invoice table tfoot tr:last-child td {
    //     color: #3989c6;
    //     font-size: 1.4em;
    //     border-top: 1px solid #3989c6
    // }

    // .invoice table tfoot tr td:first-child {
    //     border: none
    // }

    // .invoice footer {
    //     width: 100%;
    //     text-align: center;
    //     color: #777;
    //     border-top: 1px solid #aaa;
    //     padding: 8px 0
    // }

    // @media print {
    //     .invoice {
    //         font-size: 11px!important;
    //         overflow: hidden!important
    //     }

    //     .invoice footer {
    //         position: absolute;
    //         bottom: 10px;
    //         page-break-after: always
    //     }

    //     .invoice>div:last-child {
    //         page-break-before: always
    //     }
    // }</style></head>`);

            a.document.write("<body>");

            a.document.write(`<div class="invoice-box">
                     <table  style="width: 100%;border: 2px solid black;">
                                <thead>
                                        <tr>
                                    <td
                                      rowspan="4"
                                      style="text-align: center; line-height: 0px"
                                    > <br />
                                      <h4>الجمهوريه اليمنيه</h4>
                                   
                                      <h4>وزاره الدفاع</h4>
                                  
                                    <h4>رئاسه هيئه الاركات</h4>
                           
                              <h4>قياده القوات الجويه والدفاع</h4>
                                    
                                      <h4>الدراسات والابحاث</h4>
                                  
                                      <h4>المخازن</h4>
                                 
                                    </td>
                                    <td
                                      rowspan="4"
                                      style="text-align: center; line-height: 0px"
                                    >
                                      <img
                                        src='/assets/img/images3.jpg'
                                        height="100px"
                                        alt="products image"
                                      />
                                      <h3>${name}</h3>
                                    </td>
                                    <td
                                      rowspan="4"
                                      style="text-align: center; line-height: 0px"
                                    >
                                     
                                          <h4>التاريخ:_______________</h4>
                                          <h4>فاكس____________________<h4>
                                          <h4> الهاتف_________________<h4>
                                    </td>
                                  </tr>
                                  <tr></tr>
          
                                  <tr></tr>
                                  <tr>
                                    <td colspan="1"></td>
          
                                    <td style="text-align: left">
                                      <button @click="printDiv('printme')">
                                        <i
                                          class="fas fa-print"
                                          style="font-size: 24px; color: rgb(34, 192, 60)"
                                        ></i>
                                      </button>
                                    </td>
                                  </tr>
                               
                                </thead>
                              </table>
                 
                    </div>`);

            a.document.write(printContents);

            a.document.write("</body></html>");
            a.document.close();
            a.print();
        },
    },
};
