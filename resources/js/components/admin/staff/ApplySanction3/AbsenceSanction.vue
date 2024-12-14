<template>
  <!-- row opened -->
  <div class="container-fluid">

    <div class="card">


      <div class="card-header">

        <span class="h4">    لائحة الغياب</span>
    

      </div>

      <div class="card-body">

        <div class="row row-sm">
          <div class="col-xl-12">
            <div class="card">

              <div class="card-body">

                <div class="row row-sm">
                  <div class="col-xl-12">
                    <!-- <form method="post"> -->
                    <div class="card">

                      <div class="card-body">
                        <form method="post">

                          <div class="table-responsive">
                            <table class="table table-bordered text-right m-t-30"
                              style="width: 100%; font-size: x-small">
                              <thead>
                                <tr>


                                  <!-- <th>اسم الموظف</th> -->
                                  <th>الغياب</th>
                    
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="index in count" :key="index">
                                  <!-- <td>
                          <select v-model="staffselected[index]" name="type" id="type" class="form-control "
                            required>
                            <option v-for="staff in staffs" v-bind:value="staff.id">
                              {{ staff.name }}
                            </option>
                          </select>
                        </td> -->
                                  <td>
                                    <select v-model="absenceselected[index]" name="type" id="type" class="form-control "
                                      required>
                                      <option v-for="absence in absence_types" v-bind:value="absence.id">
                                        {{ absence.name }}
                                      </option>
                                    </select>
                                  </td>

                             
                              





                                </tr>

                            


                              </tbody>
                            </table>
                          </div>



                        </form>

                      </div>

                    </div>


                    <!-- </form> -->
                  </div>
                </div>
              </div>
            </div>
          </div>






        </div>

        <div class="row row-sm">

          <div class="card-body" id="printme">

            <div class="row">

              <div class="col-md-6">

                <div class="card">


                  <div class="card-header">

                    <span class="h4">  تفاصبل اللائحة</span>
                  
                  </div>
                  <div class="card-body">

                    <div class="table-responsive">
                      <table class="table table-bordered text-center">
                        <thead>
                          <tr>
                            <th class="wd-15p border-bottom-0">#</th>
                            <!-- <th class="wd-15p border-bottom-0">اسم الموظف</th> -->
              
                            <th class="wd-15p border-bottom-0">عدد مرات التكرار</th>
                            <th class="wd-15p border-bottom-0"> طريقه الخصم</th>
                            <th class="wd-15p border-bottom-0"> طريقه الاحتساب</th>
                            <th class="wd-15p border-bottom-0"> الجزاء</th>
                            <!-- <th class="wd-15p border-bottom-0"> الحاله</th> -->

                            <th class="wd-15p border-bottom-0">العمليات</th>
                          </tr>
                        </thead>
                        <tbody v-if="value_list && value_list.data.length > 0">
                          <tr v-for="(absence_sanction, index) in value_list.data" :key="index">
                            <td>{{ index + 1 }}</td>
                            <!-- <td>{{ absence_sanction.staff_name }}</td> -->
                     
                            <td v-if="absence_sanction.iteration == 1"> مره واحده</td>
                            <td v-if="absence_sanction.iteration == 2"> مرتين</td>
                            <td v-if="absence_sanction.iteration == 3">ثلاث مرات</td>
                            <td v-if="absence_sanction.iteration == 4">اربع مرات</td>
                            <td v-if="absence_sanction.iteration == 5"> خمس مرات او اكثر</td>
                            <td v-if="absence_sanction.iteration == 6"> اي مره</td>
                            <td>{{ absence_sanction.discount_name }}</td>
                            <td v-if="absence_sanction.discount == 1">قيمه</td>
                            <td v-if="absence_sanction.discount == 2">نسبه</td>
                            <td>{{ absence_sanction.sanction }}</td>


                            <td>
                              <a type="button" @click="delete_item(delay_sanction.id)"
                            class="btn btn-success btn-sm waves-effect">
                             عرض 
                          </a>
                          <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="btn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                          <a type="button" @click="delete_item(delay_sanction.id)"
                            class="btn btn-danger btn-sm waves-effect">
                            تطبيق 
                          </a>

                            </td>
                          </tr>
                        </tbody>
                        <tbody v-else>
                          <tr>
                            <td align="center" colspan="6">لايوجد بياتات.</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <pagination align="center" :data="value_list" @pagination-change-page="list"></pagination>

                  </div>
                </div>

              </div>
              <div class="col-md-6">


                <div class="card">
                  <div class="card-header">

                    <span class="h4">  غياب الموظف</span>
                  
                  </div>
                  <div class="card-body">

                    <div class="table-responsive">
                      <table class="table table-bordered text-center">
                        <thead>
                          <tr>
                            <th class="wd-15p border-bottom-0">#</th>
                            <th class="wd-15p border-bottom-0">اسم الموظف</th>
                            <th class="wd-15p border-bottom-0">الغياب</th>
               
                

     
                          </tr>
                        </thead>
                        <tbody v-if="value_list && value_list.data.length > 0">
                          <tr v-for="(absence_sanction, index) in value_list.data" :key="index">
                            <td>{{ index + 1 }}</td>
                            <!-- <td>{{ absence_sanction.staff_name }}</td> -->
                            <td></td>
            
                            <td>{{ absence_sanction.discount_name }}</td>
               
                

                          </tr>
                        </tbody>
                        <tbody v-else>
                          <tr>
                            <td align="center" colspan="6">لايوجد بياتات.</td>
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






        </div>
      </div>
    </div>


  </div>

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


      value_list: {
        type: Object,
        default: null,
      },
      discountselected: [],
      absenceselected: [],
      iterationselected: [],
      discounttypeselected: [],
      sanctionselected: [],

    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'absence_sanction';
  },
  methods: {


    Add_new() {

      this.Add(
        {
          type: this.type,
          count: this.counts,
          // staff:this.staffselected,
          discount: this.discountselected,
          absence: this.absenceselected,
          iteration: this.iterationselected,
          discount_type: this.discounttypeselected,
          sanction: this.sanctionselected,
        });


    },

    list(page = 1) {
      this.axios
        .post(`/absence_sanction?page=${page}`)
        .then(({ data }) => {

          // console.log(data.absence_types)
          this.absence_types = data.absence_types;
          this.discount_types = data.discount_types;
          this.staffs = data.staffs;
          this.value_list = data.list;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },


  },
};
</script>
