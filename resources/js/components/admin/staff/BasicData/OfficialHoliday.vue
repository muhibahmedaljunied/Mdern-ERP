<template>

  <div class="container-fluid">

    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">

            <span class="h2">العطل الرسميه</span>
            <div style="display: flex;float: left; margin: 5px">



              <div>

              </div>
            </div>
          </div>

          <div class="card-body">
            <form method="post" enctype="multipart/form-data">

              <div class="table-responsive">
                <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                  <thead>
                    <tr>

                      <th> الاسم</th>

                      <th> من</th>
                      <th> الي</th>

                      <th> المده</th>





                      <th>اضافه</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="index in count" :key="index">
                      <td>
                        <input v-model="holiday[index]" type="text" class="form-control" name="name" id="name"
                          required />

                      </td>
                      <td>




                        <input @change="calc_time(index)" v-model="start_date[index]" type="date" class="form-control"
                          name="exampleRadios" />



                      </td>
                      <td>


                        <input @change="calc_time(index)" v-model="end_date[index]" type="date" name="exampleRadios"
                          class="form-control" />

                      </td>
                      <td>
                        <!-- <input @keypress="calc_time(index)" v-model="days[index]" type="number" id="num_days"
                          name="exampleRadios" class="form-control" /> -->

                        <input v-model="days[index]" type="number" id="num_days" name="exampleRadios"
                          class="form-control" />

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
                      <td> <button type="button" class="btn btn-primary" @click="Add_new()">حفظ </button>
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
            <!-- <span class="h2"> الموردين</span> -->

            <div style="display: flex;float: left; margin: 5px">


              <button @click="Export()">
                <i class="fas fa-file-export" style="font-size: 24px; color: #ee335e"></i>
              </button>

              <button @click="Import()">
                <i class="fas fa-file-import" style="font-size: 24px; color: #22c03c"></i>
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
                    <th class="wd-15p border-bottom-0">#</th>
                    <th class="wd-15p border-bottom-0">الاسم</th>
                    <th class="wd-15p border-bottom-0">تاريخ البدء</th>
                    <th class="wd-15p border-bottom-0">تاريخ الانتهاء</th>
                    <th class="wd-15p border-bottom-0">المده</th>


                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="official_holiday && official_holiday.data.length > 0">
                  <tr v-for="(official_holidays, index) in official_holiday.data" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>{{ official_holidays.name }}</td>
                    <td>{{ official_holidays.from_date }}</td>
                    <td>{{ official_holidays.into_date }}</td>
                    <td>{{ official_holidays.duration }}</td>
                    <td>
                      <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                      <button type="button" @click="delete_extra_type(official_holidays.id)"
                        class="btn btn-sm waves-effect btn-danger">
                        <i class="fa fa-trash"></i>
                      </button>

                      <router-link :to="{
                        name: 'edit_branch',
                        params: { id: official_holidays.id },
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
            <pagination align="center" :data="official_holidays" @pagination-change-page="list"></pagination>
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


      official_holiday: {
        type: Object,
        default: null,
      },

      holiday: [],
      start_date: [],
      end_date: [],
      days: [],

    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'official_holiday';
  },
  methods: {


   
    list(page = 1) {
      this.axios
        .post(`/official_holiday?page=${page}`)
        .then(({ data }) => {
          this.official_holiday = data.official_holidays;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

    calc_time(index) {


      var start_date = this.start_date[index].split("-");
      var end_date = this.end_date[index].split("-");

      var date1 = new Date(`${start_date[0]}/${start_date[1]}/${start_date[2]}`);
      var date2 = new Date(`${end_date[0]}/${end_date[1]}/${end_date[2]}`);
      var Difference_In_Time = date2.getTime() - date1.getTime();
      var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
      console.log("Total number of days between dates <br>"
        + date1 + "<br> and <br>"
        + date2 + " is: <br> "
        + Difference_In_Days);

      this.days[index] = Difference_In_Days;
      $(`#num_days`).val(Difference_In_Days);



    },
    Add_new() {

      this.axios
        .post(`/store_official_holiday`, {
          count: this.counts,
          holiday: this.holiday,
          start_date: this.start_date,
          end_date: this.end_date,
          days: this.days,

        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          this.list();
        });




    },



  },
};
</script>