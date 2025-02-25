<template>
  <!-- row opened -->
  <div class="container-fluid">
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">


            <h2>دوام الموظفين</h2>
          </div>


          <div class="card-body" id="printme">
            <div class="row">
              <div class="col-md-2">
                <label for="status">اسم الموظف</label>
                <select @change="select_staff" v-model="staff_selected" name="type" id="type" class="form-control "
                  required>
                  <option v-for="staff in staffs" v-bind:value="staff.id">
                    {{ staff.name }}
                  </option>
                </select>
              </div>
              <div class="col-md-2">
                <label for="status"> نوع الدوام</label>
                <select style="background-color:beige" v-model="work_system_type[index]" class="form-control " required>
                  <option v-for="work_system_type in work_system_types" v-bind:value="work_system_type.id">
                    {{ work_system_type.name }}
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
                  <th class="wd-15p border-bottom-0">#</th>
                  <th class="wd-15p border-bottom-0">الموظف</th>
                  <th class="wd-15p border-bottom-0"> نوع الدوام</th>
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
                        <td align="center" colspan="3">لايوجد بياتات.</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <pagination align="center" :data="discounts" @pagination-change-page="list"></pagination>
              </div>





            </div>

          </div>
        </div>
        <!--/div-->
      </div>
    </div>

  </div>
  <!-- /row -->
</template>

<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../../staff/StaffData/staff_data.js';

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
  mounted() {
    this.list();
    this.type = 'discount';
  },
  methods: {






    report() {
      this.axios
        .post(`/work_system_report`, {
          type: this.type,
          staff: this.staff_selected,
          from_date: this.from_date,
          into_date: this.into_date,
        })
        .then(({ data }) => {
          this.list_data = data.list;

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

  },
};
</script>
