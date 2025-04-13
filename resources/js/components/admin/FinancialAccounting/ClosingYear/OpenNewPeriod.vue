<template>
  <div class='container-fluid'>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <!-- <form method="post" @submit.prevent="submitForm"> -->

          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2"> فتح سنه ماليه جديده</span>
            </div>
          </div>
          <div class="card-body">


            <div class="row">
              <div class="col-md-6">
                <div class="table-responsive">
                  <table class="table table-bordered text-center">
                    <thead>
                      <tr>
                        <th class="wd-15p border-bottom-0">الرقم التسلسلي</th>
                        <th class="wd-15p border-bottom-0">الفتره</th>
                        <th class="wd-15p border-bottom-0"> تأريخ البدء</th>
                        <th class="wd-15p border-bottom-0">تأريخ الانتهاء</th>

                        <!-- <th>اضافه</th> -->
                      </tr>
                    </thead>
                    <tbody>

                      <tr v-for="index in count" :key="index">

                        <td>
                          {{ index+1 }}
                        </td>
                        <td>
                          <input v-model="year" type="number" min="1900" max="2099" step="1" />
                        </td>
                        <td>
                          <input required type="date" v-model="start_date" class="form-control input_cantidad" />
                        </td>

                        <td>
                          <input type="date" v-model="end_date" class="form-control input_cantidad"
                            onkeypress="return valida(event)" />
                        </td>







                      </tr>

                      <!-- <tr v-for="index in count" :key="index">

                    <td>
                      <input v-model="year" type="number" min="1900" max="2099" step="1" />
                    </td>
                    <td>
                      <input required type="date" :id="'Daily_account_tree_id' + index" name="account_id"
                        class="form-control input_cantidad" />
                    </td>

                    <td>
                      <input v-model="credit[index]" type="date" style="width: 150px" id="qty"
                        class="form-control input_cantidad" onkeypress="return valida(event)" />
                    </td>
                    <td>

                    <td colspan="4"> <a href="javascript:void" @click="create_period()" class="btn btn-primary"><span>بدء فتره
                          ماليه جديده
                        </span></a></td>
                    </td>



              
                  </tr> -->

                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-4">

                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="">
                    <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                    نقل الادخالات الاساسيه من الفترات السابقه
                  </label>
                </div>

                <div class="checkbox">
                  <label>
                    <input @change="set_val(account, 'accounts')" type="checkbox" v-model="account">
                    <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                    المحاسبه الماليه
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input @change="set_val(asset, 'assets')" type="checkbox" checked v-model="asset">
                    <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                    الاصول الثابته </label>
                </div>
                <div class="checkbox disabled">
                  <label>
                    <input @change="set_val(store, 'stores')" type="checkbox" v-model="store">
                    <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                    المخزون </label>
                </div>
                <div class="checkbox">
                <label>
                  <input @change="set_val(staff, 'staff')" type="checkbox" v-model="staff">
                  <span class="cr"><i class="cr-icon glyphicon glyphicon-arrow-right"></i></span>
                  الموظفين </label>
              </div>

       

          
              <div class="checkbox">
                <label>
                  <input @change="set_val(staff, 'staff')" type="checkbox" v-model="product">
                  <span class="cr"><i class="cr-icon glyphicon glyphicon-arrow-right"></i></span>
                  الاصناف </label>
              </div>
              </div>

              <div class="col-md-2">
                <a href="javascript:void" @click="create_period()"
                            class="btn btn-primary"><span>بدء
                              فتره
                              ماليه جديده
                            </span></a>
              </div>







            </div>


          </div>
        </div>
      </div>



      <!-- </form> -->
    </div>



    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <!-- <form method="post" @submit.prevent="submitForm"> -->

          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2"> الفترات الماليه</span>
            </div>
          </div>
          <div class="card-body" id="printme">


            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">الرقم التسلسلي</th>
                    <th class="wd-15p border-bottom-0">الفتره</th>
                    <th class="wd-15p border-bottom-0"> تأريخ البدء</th>
                    <th class="wd-15p border-bottom-0">تأريخ الانتهاء</th>

                    <th>العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="value_list && value_list.length > 0">
                  <tr v-for="(period, index) in value_list" :key="index">

                    <td>
                      {{ index+1 }}
                    </td>
                    <td>{{ period.name }}</td>
                    <td>{{ period.start_date }}</td>
                    <td>{{ period.end_date }}</td>


                  </tr>

                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>



      <!-- </form> -->
    </div>

  </div>
</template>
<script>
import tree from '../../../../../js/tree/tree.js';

export default {
  mixins: [tree],
  data() {
    return {

      value_list: '',
      counts: {},
      year: 2024,
      start_date: '',
      end_date: '',
      account: '',
      store: '',
      asset: '',
      staff: '',
      count: 1,
      index: 0,
      data_check: [],
      data_for_initial: '',
      start_date: new Date().toISOString().substr(0, 10),
      end_date: new Date().toISOString().substr(0, 10),

    };
  },
  mounted() {
    this.list();
  },

  methods: {

    list() {

      this.axios
        .post(`/account_year`)
        .then(({ data }) => {
          console.log('dailydd', data.account_years);
          this.value_list = data.account_years;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

    set_val(v, value) {


      if (v == true) {

        this.data_check.push(value);
      } else {

        this.data_check.pop(value);
      }
    },
    // addComponent(index) {
    //   // alert(index);
    //   this.count += 1;
    //   this.counts[index] = this.count;
    // },
    // disComponent(index) {
    //   this.count -= 1;
    //   this.$delete(this.counts, index);
    // },

    create_period() {
      this.data_for_initial = [
        'sanction_discounts',
        'account_years',
        'administrative_structures',
        'branches',
        'nationalities',
        'staff_types',
        'qualifications',
        'staff_religions',
        'currencies',
        'staff',
        // 'advances',
        // 'dailies',
        'delay_types',
        'group_types',
        'groups',
        'discount_types',
        'extra_types',
        'iterations',
        'leave_types',
        'parts',
        'official_holidays',
        'period_times',
        'personalities',
        'roles',
        'statuses',
        'accounts',
        'stores',
        'products',
        'suppliers',
        'banks',
        'treasuries',
        'units',
        'absence_types',
        // 'absences',
        // 'absence_details',
        'absence_sanctions',
        'customers',
        'allowance_types',
        // 'allowances',
        // 'attendances',
        // 'attendance_details',
        // 'cashes',
        // 'cash_details',
        // 'cash_returns',
        // 'cash_return_details',
        // 'daily_details',
        // 'delays',
        'delay_sanctions',
        'discounts',
        // 'expences',
        // 'extras',
        'extra_sanctions',
        'group_accounts',
        'group_account_details',
        // 'group_account_daily_details',
        // 'staff_group_daily_details',
        // 'staff_sanctions',
        // 'leaves',
        'leave_sanctions',
        // 'purchases',
        // 'purchase_details',
        // 'payable_notes',
        'product_units',
        // 'purchase_returns',
        // 'purchase_return_details',
        // 'sale',
        // 'sale_details',
        // 'sale_returns',
        // 'sale_return_details',
        // 'receivable_notes',
        'vacation_types',
        // 'vacations',
        'work_system_types',
        'work_systems',
        // 'staff_work_systems',
        'users',
        'transfers',
        'transfer_details',









      ]


      this.axios
        .post("/store_account_period", {

          // count: this.counts,
          year: this.year,
          start_date: this.start_date,
          end_date: this.end_date,
          data: this.data_for_initial,

        })
        .then(function (response) {
          console.log(response);
          currentObj.success = response.data.success;
          currentObj.filename = "";


          toastMessage("تم الاضافه بنجاح");
        })
        .catch(function (error) {
          currentObj.output = error;
        });

      // this.$router.go(-1);
    },
  },
};
</script>
