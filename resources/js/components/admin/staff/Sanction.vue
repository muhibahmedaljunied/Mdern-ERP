<template>
  <div class="container-fluid">
    <div class="row row-sm">
      <div class="col-lg-12 col-md-12">
        <div class="card" id="basic-alert">
          <div class="card-header">
            لوائح الحضور والغياب

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
                        <li class="nav-item">
                          <a href="#tab1" class="nav-link" data-toggle="tab">غياب</a>
                        </li>

                    
                        <li class="nav-item">
                          <a href="#tab2" class="nav-link" data-toggle="tab"> تأخير</a>
                        </li>

                        <li class="nav-item">
                          <a href="#tab3" class="nav-link" data-toggle="tab"> اضافي</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab4" class="nav-link" data-toggle="tab"> انصراف المبكر</a>
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
import AbsenceSanction from "./Sanction/AbsenceSanction";
import DelaySanction from "./Sanction/DelaySanction";
import ExtraSanction from "./Sanction/ExtraSanction";
import LeaveSanction from "./Sanction/LeaveSanction";




export default {
  components: {
    AbsenceSanction,
    DelaySanction,
    ExtraSanction,
    LeaveSanction,




  },





};

</script>