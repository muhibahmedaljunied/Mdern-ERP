<template>
    <div class="container-fluid">
        <div class="row row-sm">
            <div class="col-lg-12 col-md-12">
                <div class="card" id="basic-alert">
                    <div class="card-header">
                        ترميزات النظام
                    </div>
                    <div class="card-body">
                        <!-- <div>
                      <h6 class="card-title mb-1">Basic Style Tabs</h6>
                      <p class="text-muted card-sub-title">It is Very Easy to Customize and it uses in your website apllication.</p>
                  </div> -->
                        <div class="text-wrap">
                            <div class="example">
                                <div class="panel panel-primary tabs-style-1">
                                    <div class="tab-menu-heading">
                                        <div class="tabs-menu1">
                                            <!-- Tabs -->
                                            <ul class="nav panel-tabs main-nav-line">
                                                <!-- <li class="nav-item">
                                                    <a href="#tab1" class="nav-link" data-toggle="tab">ترميز
                                                        الحسابات</a>
                                                </li> -->
                                                <li class="nav-item">
                                                    <a href="#tab2" class="nav-link" data-toggle="tab">ترميز الموارد
                                                        البشريه</a>
                                                </li>
                                                <!-- <li class="nav-item">
                                                    <a href="#tab3" class="nav-link" data-toggle="tab"> ترميز
                                                        المخازن</a>
                                                </li> -->

                                                <li class="nav-item">
                                                    <a href="#tab4" class="nav-link" data-toggle="tab"> ترميز
                                                        العملاء</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#tab5" class="nav-link" data-toggle="tab">ترميز
                                                        الموردين</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#tab6" class="nav-link" data-toggle="tab"> ترميز
                                                        الصناديق</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#tab7" class="nav-link" data-toggle="tab">ترميز البنوك</a>
                                                </li>








                                            </ul>
                                        </div>
                                    </div>
                                    <div class="
                        panel-body
                        tabs-menu-body
                        main-content-body-right
                        border-top-0 border
                      ">
                                        <div class="tab-content">
                                            <!-- <div class="tab-pane active" id="tab1">
                                                <mark-account></mark-account>
                                            </div> -->
                                            <div class="tab-pane active" id="tab2">
                                                <mark-hr></mark-hr>
                                            </div>
                                            <!-- <div class="tab-pane" id="tab3">
                                                <mark-store></mark-store>
                                            </div> -->
                                            <div class="tab-pane" id="tab4">
                                                <mark-customer></mark-customer>
                                            </div>
                                            <div class="tab-pane" id="tab5">
                                                <mark-supplier></mark-supplier>
                                            </div>
                                            <div class="tab-pane" id="tab6">
                                                <mark-treasury></mark-treasury>
                                            </div>
                                            <div class="tab-pane" id="tab7">
                                                <mark-bank></mark-bank>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- End Prism Precode -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import MarkAccount from "./SystemMark/MarkAccount";
import MarkHr from "./SystemMark/MarkHr";
// import MarkStore from "./SystemMark/MarkStore";
import MarkCustomer from "./SystemMark/MarkCustomer";
import MarkSupplier from "./SystemMark/MarkSupplier";
import MarkTreasury from "./SystemMark/MarkTreasury";
import MarkBank from "./SystemMark/MarkBank";
export default {
    components: {
        MarkAccount,
        MarkHr,
        // MarkStore,
        MarkCustomer,
        MarkSupplier,
        MarkTreasury,
        MarkBank,
    },





};

</script>