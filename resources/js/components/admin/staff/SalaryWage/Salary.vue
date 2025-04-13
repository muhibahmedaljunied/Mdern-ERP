<template>
  <!-- row opened -->

  <div class="container-fluid">

    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">


            <h2> الراتب </h2>

          </div>




          <div class="card-body" id="printme">
            <div class="row">
              <div class="col-md-4">
                <label for="inputAddress">الفرع</label>
                <select style="background-color: beige;" v-model="branchselected" class="form-control" required>
                  <option v-for="branch in branches" v-bind:value="branch.id">
                    {{ branch.name }}
                  </option>
                </select>
              </div>
              <div class="col-md-4">

                <label for="status"> الهيكل الاداري</label>

                <!-- <input v-model="debit" type="hidden" class="form-control" required /> -->
                <div class="custom-search">

                  <input style="background-color: beige;" :id="'AdministrativeStructure_account_tree'" type="text"
                    readonly class="custom-search-input">
                  <input :id="'AdministrativeStructure_account_tree_id'" type="hidden" readonly
                    class="custom-search-input">

                  <button class="custom-search-botton" type="button" data-toggle="modal"
                    data-target="#exampleModalAccountAdministrativeStructure">
                    <i class="fa fa-plus-circle"></i></button>
                </div>


              </div>

              <div class="col-md-4">

                <label for="status"> الحساب</label>

                <!-- <input v-model="debit" type="hidden" class="form-control" required /> -->
                <div class="custom-search">

                  <input style="background-color: beige;" :id="'Salary_account_tree'" type="text" readonly
                    class="custom-search-input">
                  <input :id="'Salary_account_tree_id'" type="hidden" readonly class="custom-search-input">

                  <button class="custom-search-botton" type="button" data-toggle="modal"
                    data-target="#exampleModalAccountSalary">
                    <i class="fa fa-plus-circle"></i></button>
                </div>


              </div>



            </div>
            <br>

            <div class="row">




              <div class="col-md-4">
                <label for="status">اسم الموظف</label>
                <select @change="select_staff" v-model="staff_selected" name="type" id="type" class="form-control "
                  required>
                  <option v-for="staff in staffs" v-bind:value="staff.id">
                    {{ staff.name }}
                  </option>
                </select>
              </div>



              <div class="col-md-4">

                <label for="">التاريخ</label>
                <input v-model="date" type="date" class="form-control" name="name" id="name" required />

              </div>

              <div class="col-sm-6 col-md-3" style="margin-top: auto;">
                <a href="#"><img src="/assets/img/search.png" alt="" style="width: 10%;"> </a>
              </div>
            </div>
            <br>




          </div>

        </div>
      </div>
      <!--/div-->
    </div>

    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">


          <div class="card-header">


            <div style="display: flex;float: left; margin: 5px">




              <button @click="exports_excel()">

                <i class="fa-solid fa-file-export " style="font-size: 24px; color: #63E6BE;"></i>
              </button>

              <button @click="imports_excel()">

                <i class="fa-solid fa-file-import " style="font-size: 24px; color: #B197FC;"></i>
              </button>

              <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button"
                aria-haspopup="true" aria-expanded="true" placeholder="بحث" v-model="word_search" />
            </div>
          </div>


          <div class="card-body">


            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>

                  <tr>
                    <th class="wd-15p border-bottom-0">الرقم الوظيفي</th>
                    <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                    <th class="wd-15p border-bottom-0"> الفرع</th>
                    <th class="wd-15p border-bottom-0">الراتب الاساسي</th>
                    <!-- <th class="wd-15p border-bottom-0">بدلات </th> -->
                    <!-- <th class="wd-15p border-bottom-0"> اضافي</th> -->
                    <!-- <th class="wd-15p border-bottom-0"> خصومات</th> -->
                    <!-- <th class="wd-15p border-bottom-0"> جزاءات</th> -->

                    <!-- <th class="wd-15p border-bottom-0"> السلف</th> -->
                    <th class="wd-15p border-bottom-0"> الصافي</th>
                    <th class="wd-15p border-bottom-0"> الحاله</th>

                    <th>العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="list_data && list_data.data.length > 0">
                  <tr v-for="(salary, index) in list_data.data" :key="index">


                    <td>{{ salary.id }}</td>
                    <td> <a @click="salary_details(salary.id)">{{ salary.name }} </a></td>
                    <td> <a >{{ salary.name }} </a></td>

                    <td>{{ salary.salary }}</td>


                    <!--<td>{{ salary.total_allowance }}</td>


                  <td>{{ salary.total_extra }}</td>

                  <td>{{ salary.all_discount }}</td>





                  <td>{{ salary.total_sanction }}</td>
 -->

                    <td>{{ salary.total }}</td>
                    <td>
                      <template>
                        <div>
                          <span class="badge bg-warning" v-if="salary.status == 'init'">معلق </span>
                          <span class="badge bg-info" v-if="salary.status == 'prove'">مستحق </span>
                          <span class="badge bg-success" v-if="salary.status == 'paid'">مدفوع </span>

                        </div>
                      </template>
                    </td>


                    <!-- 
                  <td>
                    <button @click="salary_details(salary.id)" data-toggle="tooltip" data-placement="top"
                      class="tn btn-success btn-sm waves-effect btn-agregar"> <i class="fa fa-eye"></i></button>
                    <button class="tn btn-info btn-sm waves-effect btn-agregar"> <i class="fa fa-plus"></i> </button>

                  </td> -->
                    <td>
                      <div class="optionbox">
                        <select @change="changeRoute(index, salary.salary)" v-model="operationselected[index]"
                          class="form-control">
                          <option :selected="true" class="btn btn-success" v-bind:value="[
                            'salary_details',
                            salary.id,
                            0
                          ]">
                            تفاصيل
                          </option>

                          <option v-if="salary.status != 'prove' && salary.status != 'paid'" class="btn btn-success"
                            v-bind:value="[
                              'prove_salary',
                              salary.id,
                              1
                            ]">
                            استحقاق الراتب
                          </option>
                          <option v-if="salary.status == 'prove'" class="btn btn-success" v-bind:value="[
                            'paid_salary',
                            salary.id,
                            2
                          ]">
                            صرف الراتب
                          </option>


                        </select>
                      </div>


                    </td>



                  </tr>
                  <tr>
                    <td colspan="2" style="color:red;font-size: x-large;">الاجمالي</td>

                    <td style="color:red;">{{ basic_salary }}</td>
                    <td style="color:red;">{{ net_salary }}</td>

                    <td colspan="2" style="color:green;font-size: x-large;">
                      <button @click="paid_all_salary()" class="tn btn-info btn-lg waves-effect btn-agregar"> صرف جميع
                        الرواتب </button>
                      <button @click="prove_all_salary()" class="tn btn-info btn-lg waves-effect btn-agregar"> اثبات
                        استحقاق
                        جميع الرواتب </button>

                    </td>

                  </tr>
                </tbody>



                <!-- <tbody v-else>
                <tr>
                  <td align="center" colspan="9">لايوجد بياتات.</td>
                </tr>
              </tbody> -->
              </table>
            </div>


            <div class="modal fade" id="exampleModalAccountAdministrativeStructure" tabindex="-1" role="dialog"
              aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                    <div class="well" id="treeview_json_administrative_structure"></div>

                  </div>

                </div>
              </div>
            </div>
            <div class="modal fade" id="exampleModalAccountSalary" tabindex="-1" role="dialog"
              aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                    <div class="well" id="treeview_json_account_Salary"></div>

                  </div>

                </div>
              </div>
            </div>
            <!-- <pagination align="center" :data="list_data" @pagination-change-page="list"></pagination> -->
          </div>

        </div>
      </div>
      <!--/div-->
    </div>

  </div>

  <!-- /row -->
</template>

<script>
import pagination from "laravel-vue-pagination";
// import staffdata from '../../../../../js/staff/StaffData/staff_data.js';
// import operation from '../../../../../js/staff/operation/operation.js';
// import operation2 from '../../../../../js/operation.js';
// import operation2 from '../../../../operation.js';
import tree from '../../../../../js/tree/tree.js';
import operation from '../../../../operation.js';




export default {
  components: {
    pagination,
  },
  mixins: [operation, tree],
  data() {
    return {


      list_data: {
        type: Object,
        default: null,
      },


      account: [],
      table: '',
      staff_selected: 1,
      staffs: '',



      operationselected: [],

      staffselected: 1,
      jobselected: 1,


      prove_account: '',





    };
  },
  mounted() {
    this.list();
    this.type = 'Salary';
    this.type_of_tree = 1;
    this.showtree('account', 'tree_account');
  },
  methods: {

    // salary_details(id) {

    //   this.$router.push('/salary_details/' + id);

    // },
    changeRoute(index, salary) {



      if (this.operationselected[index][2] == 1) {

        this.prove_salary(this.operationselected[index][1], salary);
      }
      if (this.operationselected[index][2] == 2) {

        this.paid_salary(this.operationselected[index][1], salary);
      }

      if (this.operationselected[index][2] == 0) {

        this.$router.push({
          name: this.operationselected[index][0],
          params: { data: this.operationselected[index][1] },
        });
      }

      // console.log(this.operationselected[index][0],this.operationselected[index][1]);

    },
    prove_salary(id, salary) {

      this.axios
        .post(`/prove_salary/${id}`, {
          type: this.type,
          date: this.date,
          credit: {
            credit_account_id: this.prove_account,
            staff: id,
            paid: salary,

          },
          debit: {

            debit_account_id: this.prove_account,
            paid: salary,

          },
          grand_total: salary,
          type_daily: 'hr_prove_salary',


        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });


    },
    prove_all_salary() {


      this.axios
        .post(`/prove_all_salary`, {
          data_staff: this.staffs,
          type: this.type,
          date: this.date,
          credit: {
            account_id: this.prove_account[0]['account_second_id'],
            value: '',
            account_details: '',
          },
          debit: {
            account_id: this.prove_account[0]['account_id'],
            value: this.basic_salary,
            account_details: '',
          },
          daily_index: 0,
          grand_total: this.basic_salary,
          type_daily: 'hr_all_prove_salary',


        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });


    },
    paid_salary(id, salary) {

      this.axios
        .post(`/paid_salary/${id}`, {
          type: this.type,
          date: this.date,
          staff: id,
          account_id: $(`#Salary_account_tree_id`).val(),
          grand_total: 0,
          type_daily: 'hr_paid_salary',



        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });


    },
    paid_all_salary() {


      this.axios
        .post(`/paid_all_salary`, {
          data_staff: this.staffs,
          type: this.type,
          date: this.date,
          account_id: $(`#Salary_account_tree_id`).val(),
          grand_total: 0,
          type_daily: 'hr_all_paid_salary',


        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });


    },

    get_search(word_search) {
      this.axios
        .post(`/salary_detailssearch`, { word_search: this.word_search })
        .then(({ data }) => {

          this.salaries = data.salaries;

        });
    },

    list(page = 1) {




      this.axios
        .post(`/salary_details?page=${page}`)
        .then(({ data }) => {
          // console.log('muhib', data);
          this.list_data = data.list;
          this.staffs = data.staffs;
          this.net_salary = data.net_salary;
          this.basic_salary = data.basic_salary;
          this.prove_account = data.prove_account;
          // this.paid_account = data.paid_account;
          // this.paid_account = data.paid_account;

          this.staffs = data.staff;


        })
        .catch(({ response }) => {
          console.error(response);
        });

    },


  },
};
//
</script>

<style scoped>
.optionbox select {
  background: #E62968;
  color: #fff;
  padding: 10px;
  width: 120px;
  height: 30px;
  border: none;
  font-size: 15px;
  box-shadow: 0 5px 18px rgb(93, 15, 9);
  /* -webkit-appearance: button; */
  outline: none;
}
</style>