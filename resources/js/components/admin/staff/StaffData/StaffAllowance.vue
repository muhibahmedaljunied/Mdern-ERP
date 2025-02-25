<template>
  <!-- row opened -->

  <div class="container-fluid">
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">

            <span class="h2"> بدلات الموظفين</span>
          </div>
          <div class="card-body" id="printme">
            <div class="row">
              <div class="col-md-4">
                <label for="status">اسم الموظف</label>
                <select v-model="staffselected[index]" id="inputState" class="form-control">
                                        <option v-for="staff in staffs" v-bind:value="staff.id">
                                          {{ staff.name }}
                                        </option>
                                      </select>
              </div>
              <div class="col-md-2">
                <label for="status"> نوع البدل</label>
                <select @change="set_allowance(allowance_status[index], index)" v-model="allowance_status[index]"
                  id="inputState" class="form-control">
                  <option v-bind:value="1">
                    بدلات شهريه
                  </option>
                  <option v-bind:value="2">
                    بدلات غير شهريه
                  </option>
                </select>
              </div>
              <div class="col-md-2">
                <label for="status"> البدل</label>
                <select v-model="allowance_type[index]" :id="'select_allowance' + index" class="form-control">
                  <!-- <option v-for="allowance_type in allowance_types"
                                        v-bind:value="[allowance_type.id, allowance_type.account_id, allowance_type.account_second_id]">
                                        {{ allowance_type.name }}
                                        </option> -->
                </select>
              </div>

              <!--<div class="col-md-2">
              <label for="status">الي تأريخ</label>
              <input v-model="into_date" type="date" name="" id="" class="form-control">
            </div> -->
              <!-- <div class="col-sm-6 col-md-3" style="margin-top: auto;">
                <a href="#" @click="report()"><img src="/assets/img/search.png" alt="" style="width: 10%;"> </a>
              </div> -->

              <div class="col-sm-6 col-md-2" style="margin-top: auto;">


                <a @click="report()" href="#">

                  <i class="fa-solid fa-magnifying-glass fa-2xl" style="color: #74C0FC;"></i>


                </a>


              </div>
            </div>

          </div>

        </div>
      </div>
      <!--/div-->
    </div>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">

          <div class="card-body" id="printme">
            <div class="row">
              <div class="table-responsive">
                <table class="table table-bordered text-center">
                  <thead>
                    <tr>
                      <!-- <th class="wd-15p border-bottom-0">الرقم الوظيفي</th> -->
                      <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                      <!-- <th class="wd-15p border-bottom-0">الفرع</th>
                  <th class="wd-15p border-bottom-0">القسم</th> -->
                      <!-- <th class="wd-15p border-bottom-0">الراتب الاساسي</th> -->

                      <th class="wd-15p border-bottom-0"> البدل</th>
                      <th class="wd-15p border-bottom-0"> نوع البدل</th>
                      <th class="wd-15p border-bottom-0"> المبلغ</th>
                      <th class="wd-15p border-bottom-0">العمليات</th>
                    </tr>
                  </thead>
                  <tbody v-if="value_list && value_list.data.length > 0">
                    <tr v-for="(staff_allowance, index) in value_list.data" :key="index">


                      <td>{{ staff_allowance.name }}</td>
                      <!-- <td>{{ staff_allowance.personal_card }}</td>
                  <td>{{ staff_allowance.job }}</td> -->
                      <!-- <td>{{ staff_allowance.salary }}</td>
                  <td>{{ staff_allowance.name }}</td> -->

                      <td>

                        <div v-for="(allowance, index) in staff_allowance.allowance" :key="index" style="color:green;">




                          {{ allowance.allowance_type.name }}
                          <hr>
                        </div>
                      </td>

                      <td>

                        <div v-for="(allowance, index) in staff_allowance.allowance" :key="index" style="color:green;">


                          <span v-if="allowance.status == 1">شهري</span>
                          <span v-else>غير شهري</span>



                          <hr>
                        </div>
                      </td>
                      <td>

                        <div v-for="(allowance, index) in staff_allowance.allowance" :key="index" style="color:red;">
                          {{ allowance.quantity }}
                          <hr>
                        </div>
                      </td>

                      <td>
                        <button type="button" class="btn btn-danger btn-sm waves-effect">
                          <i class="fa fa-trash"></i>
                        </button>


                        <a class="btn btn-info btn-sm waves-effect btn-agregar" data-target="#updateAd"
                          data-toggle="modal" id="agregar_productos">
                          <i class="fa fa-edit"></i></a>

                      </td>
                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr>
                      <td align="center" colspan="3">لايوجد بياتات.</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <pagination align="center" :data="advances" @pagination-change-page="list"></pagination>
            </div>

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
import operation from '../../../../../js/staff/operation/operation.js';

export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {
      // category: "yes",

      allowance_types: "",
      allowance_type: [],
      allowance_status: [],
      quantity: [],
      accounts: '',
      grand_total: '',
      selected_account: [[]],
      account: {
        id: [],
        account_id: [],
        account_second_id: []
      },
      date: '',
      word_search: "",
    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'allowance';
  },
  methods: {


    report() {
      this.axios
        .post(`/allowance_report`, {
          type: this.type,
          staff: this.staff_selected,
          from_date: this.from_date,
          into_date: this.into_date,
        })
        .then(({ data }) => {
          this.list_data = data.list;

        });
    },


    list(page = 1) {

      this.axios
        .post(`/allowance?page=${page}`, { type: 'allowance' })
        .then(({ data }) => {
          console.log(data);
          this.staffs = data.staffs;
          this.accounts = data.accounts;
          // this.value_list = data.list;
          this.allowance_types = data.allowance_types
          this.value_list = data.list


        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

    set_allowance(status, index) {

      axios.post(`/get_allowance`, {

        status: status
      }).then((response) => {

        var arrayLength = response.data.allowances.length
        var html = '<option></option>';
        console.log('ddddddddd', response.data.allowances);
        for (var i = 0; i < arrayLength; i++) {

          html = html + `<option data-period-${status}= ${response.data.allowances[i].allowance_type_id}   value= ${response.data.allowances[i].allowance_type_id} >    ${response.data.allowances[i].allowance_type_name}   </option>`



        }

        $(`#select_allowance${index}`).html(html);




      });

    },





  },
};
</script>
