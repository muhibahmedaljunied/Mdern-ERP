<template>
  <div class="container-fluid">
    <div class="row row-sm">
      <div class="col-lg-12 col-md-12">
        <div class="card" id="basic-alert">
          <div class="card-header">
            تطبيق لوائح الجضور والغياب والاضافي
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
                          <a href="#tab1" class="nav-link" data-toggle="tab"> غياب</a>
                        </li>

                        <li class="nav-item">
                          <a href="#tab2" class="nav-link" data-toggle="tab"> تأخير</a>
                        </li>

                        <li class="nav-item">
                          <a href="#tab3" class="nav-link" data-toggle="tab"> اضافي </a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab4" class="nav-link" data-toggle="tab"> انصراف المبكر</a>
                        </li>
                        <!-- <li class="nav-item">
                          <a href="#tab5" class="nav-link" data-toggle="tab">العطل الرسميه</a>
                        </li> -->






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
                        <absence-sanction></absence-sanction>
                      </div>


                      <div class="tab-pane" id="tab2">
                        <delay-sanction></delay-sanction>
                      </div>

                      <div class="tab-pane" id="tab3">
                        <extra-sanction></extra-sanction>
                      </div>
                      <div class="tab-pane" id="tab4">
                        <leave-sanction></leave-sanction>
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

import DelaySanction from "./ApplySanction/DelaySanction";
import AbsenceSanction from "./ApplySanction/AbsenceSanction";
import ExtraSanction from "./ApplySanction/ExtraSanction";
// import ExtraAfterSanction from "./ApplySanction/ExtraAfterSanction";

import LeaveSanction from "./ApplySanction/LeaveSanction";


export default {
  components: {

    DelaySanction,
    AbsenceSanction,
    ExtraSanction,
    // ExtraAfterSanction,
    LeaveSanction,


  },





};

</script>