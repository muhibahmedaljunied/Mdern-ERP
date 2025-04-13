<template>
  <!-- row opened -->

  <div class="container-fluid">
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">

            <span class="h2"> الاجازات</span>
          </div>
          <div class="card-body" id="printme">
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
                <label for="status"> نوع الاجازه</label>
                <select v-model="vaction_typeselected[index]" id="inputState" class="form-control">
                              <option v-for="vacation_type in vacation_types" v-bind:value="vacation_type.id">
                                {{ vacation_type.name }}
                              </option>
                            </select>
              </div>
    
          
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
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">الرقم التسلسلي</th>
                    <th class="wd-15p border-bottom-0">اسم المؤظف</th>

                    <th class="wd-15p border-bottom-0">نوع الاجازه</th>

                    <th class="wd-15p border-bottom-0">عدد الايام</th>
                    <th class="wd-15p border-bottom-0">تاريخ بدء الاجازه</th>
                    <th class="wd-15p border-bottom-0">تاريخ انتهاء الاجازه</th>

                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="value_list && value_list.data.length > 0">
                  <tr v-for="(vacation, index) in value_list.data" :key="index">
                    <td>
                      {{ index+1 }}
                    </td>
                    <td>{{ vacation.name }}</td>

                    <td>

                      <div v-for="(vacation_names, index) in vacation.vacation" :key="index">
                        {{ vacation_names.vacation_type.name }}
                        <hr>
                      </div>
                    </td>

                    <td>

                      <div v-for="(vacation_number, index) in vacation.vacation" :key="index">
                        {{ vacation_number.total_days }}
                        <hr>
                      </div>
                    </td>

                    <td>

                      <div v-for="(vacation_start_date, index) in vacation.vacation" :key="index">
                        {{ vacation_start_date.start_date }}
                        <hr>
                      </div>
                    </td>


                    <td>

                      <div v-for="(vacation_end_date, index) in vacation.vacation" :key="index">
                        {{ vacation_end_date.end_date }}
                        <hr>
                      </div>
                    </td>



                    <!-- <td>{{ vacation.type }}</td> -->
                    <!--                 
                  <td>{{ vacation.start_date }}</td>
                  <td>{{ vacation.end_date }}</td> -->
                    <!-- <td>{{ vacation.total_days }}</td> -->




                    <td>
                      <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="btn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                      <button type="button" @click="delete_holiday(vacation.id)"
                        class="btn btn-danger btn-sm waves-effect">
                        <i class="fa fa-trash"></i>
                      </button>

                      <a class="btn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
                        data-target="#addExtra">
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
            <pagination align="center" :data="value_list" @pagination-change-page="list"></pagination>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- /row -->
</template>

<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../../staff/operation/operation.js';
export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {



      vaction_typeselected: [],
      vactionselected: [],
      vactionpartselected: [],
      start_date: [],
      end_date: [],
      days: [],

      word_search: "",
    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'vaction';
  },
  methods: {
    Add_new() {

      this.Add(
        {
          type: this.type,
          count: this.counts,
          staff: this.staffselected,
          vaction_type: this.vaction_typeselected,
          vaction: this.vactionselected,
          vaction_part: this.vactionpartselected,
          start_date: this.start_date,
          end_date: this.end_date,
          days: this.days,

        });


    },
    get_search(word_search) {
      this.axios
        .post(`/vacationsearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.vacations = data;

          // this.$root.logo = "Category";
        });
    },



    calc_time(index) {


      var start_date = this.start_date[index].split("-");
      var end_date = this.end_date[index].split("-");

      var date1 = new Date(`${start_date[0]}/${start_date[1]}/${start_date[2]}`);
      var date2 = new Date(`${end_date[0]}/${end_date[1]}/${end_date[2]}`);

      // To calculate the time difference of two dates
      var Difference_In_Time = date2.getTime() - date1.getTime();

      // To calculate the no. of days between two dates
      var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

      //To display the final no. of days (result)
      console.log("Total number of days between dates <br>"
        + date1 + "<br> and <br>"
        + date2 + " is: <br> "
        + Difference_In_Days);

      this.days[index] = Difference_In_Days;
      $(`#num_days`).val(Difference_In_Days);



    },

    list(page = 1) {
      this.axios
        .post(`/staff_vacation?page=${page}`, { type: 'vacation' })
        .then(({ data }) => {


          this.value_list = data.list;
          this.vacation_types = data.vacation_types;
          this.staffs = data.staffs;
          this.jobs = data.jobs;
          this.branches = data.branches;
          this.staff_types = data.staff_types;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

    exports_excel() {

      axios
        .post(`/export_staff`)
        .then(function (response) {

          toastMessage("تم التصدير");
          this.list();
        })
        .catch(error => {

        });
    },
    imports_excel() {

      axios
        .post(`/import_staff`)
        .then(function (response) {

          toastMessage("تم الاستيراد");
          this.list();

        })
        .catch(error => {

        });
    },


  },
};
</script>
