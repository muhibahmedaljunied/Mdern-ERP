<template>
    <div class="container-fluid">
        <div class="row row-sm">
            <div class="col-lg-12 col-md-12">
                <div class="card" id="basic-alert">
                    <div class="card-header">
                        المنتجات
                    </div>
                    <div class="card-body">

                        <div class="text-wrap">
                            <div class="example">
                                <div class="panel panel-primary tabs-style-1">
                                    <div class="tab-menu-heading">
                                        <div class="tabs-menu1">
                                            <!-- Tabs -->
                                            <ul class="nav panel-tabs main-nav-line">
                                                <li class="nav-item">
                                                    <a href="#tab1" class="nav-link" data-toggle="tab"> تباينات
                                                        المنتج</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="#tab2" class="nav-link" data-toggle="tab"> مجموعه
                                                        التباينات</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="#tab3" class="nav-link" data-toggle="tab"> الوحدات</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="#tab4" class="nav-link" data-toggle="tab"> اضافه منتج </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#tab5" class="nav-link" data-toggle="tab"> عرض المنتجات</a>
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
                                            <div class="tab-pane active" id="tab1">
                                                <attribute></attribute>
                                            </div>


                                            <div class="tab-pane" id="tab2">
                                                <attribute-family></attribute-family>
                                            </div>

                                            <div class="tab-pane" id="tab3">
                                                <unit></unit>
                                            </div>
                                            <!-- <div class="tab-pane" id="tab4">
                                                <add-product></add-product>
                                            </div> -->
                                            <div class="tab-pane" id="tab4">
<<<<<<< HEAD
                                                <new-product></new-product>
                                            </div>
                                            <div class="tab-pane" id="tab5">
                                                <product></product>
                                            </div>
                                  
=======
                                                <product></product>
                                            </div>
>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5






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

import Attribute from "../Attribute/Attribute";
import AttributeFamily from "../attribute_family/AttributeFamily";
import Unit from "../unit/Unit";
import Product from "./Product";
<<<<<<< HEAD
import NewProduct from "./NewProduct.vue";
=======
// import Product from "./Product.vue";
>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5


export default {
    components: {

        Attribute,
        AttributeFamily,
        Unit,
<<<<<<< HEAD
        NewProduct,
=======
        // AddProduct,
>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5
        Product,


    },





};

</script>