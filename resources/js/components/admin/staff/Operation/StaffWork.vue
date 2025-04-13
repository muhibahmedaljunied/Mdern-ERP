<template>
  <!-- row opened -->

  <div class="container-fluid">
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">

            <span class="h2"> الدوام</span>

          </div>
          <div class="card-body">

            <form method="post" enctype="multipart/form-data">

              <div class="table-responsive">
                <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                  <thead>
                    <tr>
                      <th >الرقم التسلسلي</th>
                      <th> الفرع</th>
                      <th> الموظف</th>

                      <th>نوع الدوام</th>
                      <th>الفتره</th>
                      <th>ايام العمل</th>



                      <th>اضافه</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="index in count" :key="index">


                      <td>
                        {{ index+1 }}
                      </td>
                      <td>

                        <select style="background-color:beige" v-model="staff[index]" class="form-control " required>
                          <option v-for="staff in staffs" v-bind:value="staff.id">
                            {{ staff.name }}
                          </option>

                        </select>
                      </td>
                      <td>

                        <select style="background-color:beige" v-model="staff[index]" class="form-control " required>
                          <option v-for="staff in staffs" v-bind:value="staff.id">
                            {{ staff.name }}
                          </option>

                        </select>
                      </td>
                      <td>

                        <select @change="get_period_time(work_system_type[index], index)" style="background-color:beige"
                          v-model="work_system_type[index]" class="form-control " required>
                          <option v-for="work_system_type in work_system_types" v-bind:value="work_system_type.id">
                            {{ work_system_type.name }}
                          </option>

                        </select>
                      </td>

                      <td>
                        <select :id="'select_period' + index" v-model="period_selected[index]" class="form-control "
                          required>
                          <!-- <option v-for="period in period_times" v-bind:value="period.id">
                            من {{ period.from_time }}الي{{ period.into_time }}
                          </option> -->

                        </select>

                      </td>
                      <td>

                        <span v-for="(day) in days">


                          &nbsp;&nbsp;<input type="checkbox" :name="day['name'] + index" :id="day['name'] + index"
                            v-model="day_value[index][day['value']]" />
                          &nbsp;&nbsp;&nbsp;



                          <label style="color:red;font-size: larger;" v-if="day['name'] == 'Friday'">
                            جمعه</label>
                          <label v-if="day['name'] == 'Satarday'"> سبت</label>
                          <label v-if="day['name'] == 'Sunday'"> احد</label>
                          <label v-if="day['name'] == 'Monday'"> اثنين</label>
                          <label v-if="day['name'] == 'Tusday'"> ثلاثاء</label>
                          <label v-if="day['name'] == 'Wedencday'"> اربعاء</label>
                          <label v-if="day['name'] == 'Thresay'"> خميس</label>


                          <!-- <label v-if="day['value'] != 0" for="radio-example-one"> {{ day['name'] }}</label>
            <label v-else  style="color:red" for="radio-example-one"> {{ day['name'] }}</label> -->
                        </span>




                      </td>




                      <td v-if="index == 1">
                        <a class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="addComponent(count)">
                          <i class="fa fa-plus-circle"></i></a>

                        <a class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="disComponent(count)">
                          <i class="fa fa-minus-circle"></i></a>
                      </td>



                    </tr>

                    <tr>

                      <td colspan="5"></td>
                      <td>

                        <button type="button" class="btn btn-primary" @click="Add_new()">حفظ </button>
                      </td>
                    </tr>


                  </tbody>
                </table>
              </div>
            </form>
          </div>









        </div>


      </div>
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
                aria-haspopup="true" aria-expanded="true" placeholder="بحث عن موظف" v-model="word_search" />
            </div>
          </div>

          <div class="card-body" id="printme">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">#</th>
                    <th class="wd-15p border-bottom-0">الموظف</th>
                    <th class="wd-15p border-bottom-0"> نوع الدوام</th>
                    <th class="wd-15p border-bottom-0">الفرع</th>
                    <th class="wd-15p border-bottom-0"> من</th>
                    <th class="wd-15p border-bottom-0"> الي</th>

                    <th class="wd-15p border-bottom-0">ايام العمل</th>


                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="value_list && value_list.data.length > 0">
                  <tr v-for="(work_system, index) in value_list.data" :key="index">
                    <td>{{ index + 1 }}</td>

                    <td>

                      {{ work_system.name }}
                    </td>
                    <td>

                      {{ work_system.work_system_type_name }}
                    </td>

                    <td>

                      {{ work_system.work_system_type_name }}
                    </td>


                    <td>

                      {{ work_system.from_time }}
                    </td>

                    <td>

                      {{ work_system.into_time }}
                    </td>



                    <td>
                      <span v-for="days in JSON.parse(work_system.days)">


                        <span style="color: red;font-size: larger;" v-if="days == 'Friday'"> جمعه</span>
                        <span v-if="days == 'Satarday'"> سبت</span>
                        <span v-if="days == 'Sunday'"> احد</span>
                        <span v-if="days == 'Monday'"> اثنين</span>
                        <span v-if="days == 'Tusday'"> ثلاثاء</span>
                        <span v-if="days == 'Wedencday'"> اربعاء</span>
                        <span v-if="days == 'Thresay'"> خميس</span>







                      </span>

                    </td>


                    <td>
                      <button type="button" @click="delete_work_system(work_system.id)"
                        class="btn btn-sm waves-effect btn-danger">
                        <i class="fa fa-trash"></i>
                      </button>

                      <router-link :to="{
                        name: 'edit_branch',
                        params: { id: work_system.id },
                      }" class="edit btn btn-sm waves-effect btn-success">
                        <i class="fa fa-edit"></i></router-link>
                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="7">لايوجد بياتات.</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>









        </div>


      </div>
    </div>

  </div>

</template>



<script>

import pagination from "laravel-vue-pagination";
import operation from '../../../../../js/staff/BasicData/operation.js';


export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {

      values: [

      ],

      value_list: {
        type: Object,
        default: null,
      },
      staffs: '',
      day_value: [],

      day: [],

      staff: [],
      work_system_type: [],

      period_selected: [],

      days: '',
      period_type_selected: '',
      sort_period: '',


    };
  },

  watch: {

    count(newVal, oldVal) {

      this.day_value[this.count] = new Array(7);
      this.day[this.count] = new Array(7);


    },
  },
  created() {

    this.counts[0] = 1;
    this.type = 'work_system';
    for (var i = 1; i <= this.count; i++) {
      this.day_value[this.count] = new Array(7); // make each element an array
      this.day[this.count] = new Array(7);
    }






  },
  mounted() {
    this.list();

  },
  methods: {

    Add_new() {

      this.axios
        .post(`/store_work_system`, {
          count: this.counts,
          staff: this.staff,
          work_system_type: this.work_system_type,
          period: this.period_selected,
          day: this.day_value,

        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
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
    list() {
      this.axios
        .post(`/work_system`)
        .then((responce) => {

          console.log('eeeewwwww', responce);
          this.value_list = responce.data.work_systems;
          this.work_system_types = responce.data.work_system_types;
          this.staffs = responce.data.staffs;
          this.period_times = responce.data.period_times;
          this.days = responce.data.days;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

    get_period_time(id, index) {



      axios.post(`/staff/get_period/${id}`).then((response) => {

        var arrayLength = response.data.periods.length
        var html = '<option></option>';
        console.log('ddddddddd', response.data.periods);
        for (var i = 0; i < arrayLength; i++) {

          html = html + `<option data-period-${id}= ${response.data.periods[i].id}   value= ${response.data.periods[i].id} > من   ${response.data.periods[i].from_time}  الي ${response.data.periods[i].into_time}</option>`



        }

        $(`#select_period${index}`).html(html);




      });

    },


  },
};
</script>
