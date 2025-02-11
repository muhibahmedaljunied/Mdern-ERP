<template>
  <div class="container-fluid">
    <div class="row row-sm">
      <div class="col-lg-12 col-md-12">
        <div class="card" id="basic-alert">
          <div class="card-header">


            <span class="h2"> ربط الحسابات</span>
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
                          <a href="#tab1" class="nav-link" data-toggle="tab">الموارد البشريه</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab2" class="nav-link" data-toggle="tab">المخازن</a>
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
                        <setting-hr></setting-hr>
                      </div>
                      <div class="tab-pane active" id="tab2">
                        <setting-warehouse></setting-warehouse>
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
import SettingHr from "./SettingAccount/SettingHr";
import SettingWarehouse from "./SettingAccount/SettingWarehouse";

export default {
  components: {
    SettingHr,
    SettingWarehouse,
  },





};

</script>