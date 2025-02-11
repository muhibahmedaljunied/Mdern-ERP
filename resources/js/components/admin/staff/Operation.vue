<template>
  <div class="container-fluid">
    <div class="row row-sm">
      <div class="col-lg-12 col-md-12">
        <div class="card" id="basic-alert">
          <div class="card-header">
            شؤون الموظفين
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
                          <a href="#tab1" class="nav-link" data-toggle="tab"> بيانات الموظف</a>                        </li>
                    
                     
                        <li class="nav-item">
                          <a href="#tab2" class="nav-link" data-toggle="tab">الدوام</a>
                        </li>

                        <li class="nav-item">
                          <a href="#tab3" class="nav-link" data-toggle="tab">الاضافي</a>
                        </li>
                           <!-- <li class="nav-item">
                          <a href="#tab3" class="nav-link" data-toggle="tab"> العهد </a>
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
                        <personal-information></personal-information>
                      </div>
              
                      <div class="tab-pane" id="tab2">
                        <staff-work></staff-work>
                      </div>

                      <div class="tab-pane" id="tab3">
                        <extra></extra>
                      </div>
                            <!-- <div class="tab-pane" id="tab22">
                        <work-system-type></work-system-type> 
                      </div> -->
                    
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
import PersonalInformation from "./Operation/PersonalInformation";
import StaffWork from "./Operation/StaffWork";
import Extra from "./Operation/Extra";




export default {
  components: {
    PersonalInformation,
    StaffWork,
    Extra,


  },





};

</script>