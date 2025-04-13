<template>
  <div class="container-fluid">


    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">

            <span class="h2"> اوقات الدوام </span>


          </div>
        </div>
      </div>
      <div class="card-body">
        <form method="post" enctype="multipart/form-data">

          <div class="table-responsive">
            <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
              <thead>
                <tr>
                  <th >الرقم التسلسلي</th>
                  <th> نوع الدوام </th>

                  <th> من</th>

                  <th> الي </th>

                  <th> عدد الساعات </th>

                  <th>اضافه</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="index in count" :key="index">
                  <td>
                    {{ index+1 }}
                  </td>
                  <td>
                    <div class="col-md-12">

                      <select style="background-color:beige" v-model="work_system_type[index]" class="form-control "
                        required>
                        <option v-for="work_system_type in work_system_types" v-bind:value="work_system_type.id">
                          {{ work_system_type.name }}
                        </option>

                      </select>


                      <!-- <input v-model="work_type[index]" type="text" class="form-control" required /> -->

                    </div>

                  </td>
                  <td>
                    <input @input="calc_duration(index)" type="time" v-model="from_period[index]" class="form-control"
                      name="name" required />

                  </td>

                  <td>
                    <input @input="calc_duration(index)" type="time" v-model="into_period[index]" class="form-control"
                      name="name" required />

                  </td>

                  <td>
                    <input type="text" class="form-control" :id="'duration_period' + index" name="name" required />

                    <input type="hidden" v-model="duration_period[index]">
                  </td>





                  <td v-if="index == 1">
                    <a class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="addComponent(count)">
                      <i class="fa fa-plus-circle"></i></a>

                    <a class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="disComponent(count)">
                      <i class="fa fa-minus-circle"></i></a>
                  </td>



                </tr>

                <tr>

                  <td colspan="4"></td>
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


    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">
            <!-- <span class="h2"> الموردين</span> -->

            <div style="display: flex;float: left; margin: 5px">


              <button @click="exports_excel()">

                <i class="fa-solid fa-file-export " style="font-size: 24px; color: #63E6BE;"></i>
              </button>

              <button @click="imports_excel()">

                <i class="fa-solid fa-file-import " style="font-size: 24px; color: #B197FC;"></i>
              </button>

              <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button"
                aria-haspopup="true" aria-expanded="true" placeholder="بحث" v-model="word_search"
                @input="get_search()" />
            </div>
          </div>

          <div class="card-body" id="printme">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">الرقم التسلسلي</th>
                    <th class="wd-15p border-bottom-0">نوع الدوام</th>
                    <th class="wd-15p border-bottom-0">من</th>
                    <th class="wd-15p border-bottom-0">الي</th>
                    <th class="wd-15p border-bottom-0"> عدد الساعات </th>


                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="period_times && period_times.length > 0">
                  <tr v-for="(period, index) in period_times" :key="index">

                    <td>{{ index + 1 }}</td>
                    <td>{{ period.work_system_type_name }}</td>
                    <td>{{ period.from_time }}</td>
                    <td>{{ period.into_time }}</td>
                    <td>{{ period.duration }}</td>

                    <td>
                      <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                      <button type="button" @click="delete_period(period.id)"
                        class="btn btn-sm waves-effect btn-danger">
                        <i class="fa fa-trash"></i>
                      </button>

                      <router-link :to="{
                        name: 'edit_branch',
                        params: { id: period.id },
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
            <pagination align="center" :data="period_times" @pagination-change-page="list"></pagination>
          </div>


        </div>
      </div>
      <!--/div-->
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


      period_times: {
        type: Object,
        default: null,
      },
      period_name: [],
      from_period: [],
      into_period: [],
      duration_period: [],
      period_selected: [],
      periods: '',
      work_system_type: [],
    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;

    this.type = 'period_time';
  },
  methods: {

    Add_new() {

      this.axios
        .post(`/store_period_time`, {
          count: this.counts,
          // type: this.period_selected,
          type: this.work_system_type,
          from_period: this.from_period,
          into_period: this.into_period,
          duration_period: this.duration_period,

        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });


    },
    calc_duration(index) {

      // console.log(this.start_time[index]);

      // var word = this.start_time[index];
      var date_current = new Date().toISOString().substr(0, 10);
      var split_start = this.from_period[index].split(":");
      var split_end = this.into_period[index].split(":");
      var date = date_current.split("-");


      // console.log(this.date[index]);


      var date1 = new Date(date[0], date[1], date[2], split_start[0], split_start[1]); // 9:00 AM
      var date2 = new Date(date[0], date[1], date[2], split_end[0], split_end[1]); // 5:00 PM
      if (date2 < date1) {
        date2.setDate(date2.getDate() + 1);
      }
      var diff = date2 - date1;
      // 28800

      // ---------------------
      var msec = diff;
      var hh = Math.floor(msec / 1000 / 60 / 60);
      msec -= hh * 1000 * 60 * 60;
      var mm = Math.floor(msec / 1000 / 60);
      msec -= mm * 1000 * 60;
      var ss = Math.floor(msec / 1000);
      msec -= ss * 1000;
      // diff = 28800000 => hh = 8, mm = 0, ss = 0, msec = 0

      console.log(hh, mm);


      this.duration_period[index] = hh;
      $(`#duration_period${index}`).val(`${hh}ساعه,${mm}دقيقه`);

    },
    list(page = 1) {
      this.axios
        .post(`/period_time?page=${page}`)
        .then(({ data }) => {


          this.work_system_types = data.work_system_types;

          this.period_times = data.period_times;
          // this.periods = data.periods;
        })
        .catch(({ response }) => {
          console.error(response)
        });
    },

    exports_excel() {

      axios
        .post(`/export_period_time`)
        .then(function (response) {

          toastMessage("تم التصدير");
          this.list();
        })
        .catch(error => {

        });
    },
    imports_excel() {

      axios
        .post(`/import_period_time`)
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
