<template>
  <!-- row opened -->

  <div class="container-fluid">

    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">

            <span class="h2"> الاضافي</span>
            <div style="display: flex;float: left; margin: 5px">


              <input autocomplete="on" v-model="word_search" type="text" class="form-control input-text"
                placeholder="بحث ...." aria-label="Recipient's username" aria-describedby="basic-addon2"
                @input="get_search()">

              <div>

              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="card-body">

        <div class="row row-sm">
          <div class="col-xl-12">
            <div class="card">

              <div class="card-body">
                <form method="post" @submit.prevent="submitForm" enctype="multipart/form-data">

                  <div class="table-responsive">
                    <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                      <thead>
                        <tr>
                          <!-- <th>اسم الموظف</th> -->
                          <th>الاضافي</th>
                          <th> المده</th>
                          <th>عدد مرات التكرار</th>
                          <th> طريقه الاحتساب</th>
                          <th> الجزاء</th>







                          <th>اضافه</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="index in count" :key="index">

                          <!-- <td>
                                          <select v-model="staffselected[index]" name="type" id="type"
                                            class="form-control " required>
                                            <option v-for="staff in staffs" v-bind:value="staff.id">
                                              {{ staff.name }}
                                            </option>
                                          </select>
                                        </td> -->
                          <td>
                            <select v-model="extraselected[index]" name="type" id="type" class="form-control " required>
                              <option v-for="extra in extra_types" v-bind:value="extra.id">
                                {{ extra.name }}
                              </option>
                            </select>
                          </td>

                          <td>
                            <select v-model="extrapartselected[index]" name="type" id="type" class="form-control "
                              required>
                              <option v-for="extra_part in extra_parts" v-bind:value="extra_part.id">
                                {{ extra_part.name }}
                              </option>
                            </select>
                          </td>


                          <td>
                            <select v-model="iterationselected[index]" name="type" id="type" class="form-control "
                              required>
                              <option v-bind:value="1">
                                مره واحده
                              </option>

                              <option v-bind:value="2">
                                مرتين
                              </option>

                              <option v-bind:value="3">
                                ثلاث مرات
                              </option>

                              <option v-bind:value="4">
                                اربع مرات
                              </option>

                              <option v-bind:value="5">
                                خمس مرات او اكثر
                              </option>
                              <option v-bind:value="6">
                                اي مره
                              </option>
                            </select>
                          </td>
                          <td>
                            <select v-model="discounttypeselected[index]" name="type" id="type" class="form-control "
                              required>
                              <option v-for="discount in discount_types" v-bind:value="discount.id">
                                {{ discount.name }}
                              </option>
                            </select>
                          </td>
                          <td>
                            <input v-model="sanctionselected[index]" type="text" class="form-control" name="name"
                              id="name" required />

                          </td>


                          <td v-if="index == 1">
                            <a class="btn btn-info btn-sm waves-effect btn-agregar" v-on:click="addComponent(count)">
                              <i class="fa fa-plus-circle"></i></a>

                            <a class="btn btn-info btn-sm waves-effect btn-agregar" v-on:click="disComponent(count)">
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

      </div>


<!-- اللائحة النموذجية للجزاءات وتنظيم العمل - الجزء الثاني ( لائحة الجزاءات ) -->
    </div>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">

          <div class="card-body" id="printme">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">#</th>
                    <!-- <th class="wd-15p border-bottom-0">اسم الموظف</th> -->
                    <th class="wd-15p border-bottom-0">الاضافي</th>
                    <th class="wd-15p border-bottom-0">المده</th>
                    <th class="wd-15p border-bottom-0">عدد مرات التكرار</th>
                    <th class="wd-15p border-bottom-0"> الجزاء</th>

                    <!-- <th class="wd-15p border-bottom-0"> الحاله</th> -->

                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="value_list.data && value_list.data.length > 0">
                  <tr v-for="(extra_sanction, index) in value_list.data" :key="index">
                    <td>{{ index + 1 }}</td>
                    <!-- <td>{{ extra_sanction.staff_name }}</td> -->
                    <td>{{ extra_sanction.extra }}</td>
                    <td>{{ extra_sanction.duration }}</td>

                    <td v-if="extra_sanction.iteration == 1"> مره واحده</td>
                    <td v-if="extra_sanction.iteration == 2"> مرتين</td>
                    <td v-if="extra_sanction.iteration == 3">ثلاث مرات</td>
                    <td v-if="extra_sanction.iteration == 4">اربع مرات</td>
                    <td v-if="extra_sanction.iteration == 5"> خمس مرات او اكثر</td>
                    <td v-if="extra_sanction.iteration == 6"> اي مره</td>

                    <td>{{ extra_sanction.sanction }}</td>


                    <td>
                      <button type="button" @click="delete_item(extra_sanction.id)"
                        class="btn btn-danger btn-sm waves-effect">
                        <i class="fa fa-trash"></i>
                      </button>

                      <a class="btn btn-info btn-sm waves-effect btn-agregar" data-target="#updateSE"
                        data-toggle="modal" id="agregar_productos">
                        <i class="fa fa-edit"></i></a>
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
            <pagination align="center" :data="value_list" @pagination-change-page="list"></pagination>
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


 
      extra_types:'',
      extra_parts:'',
      discount_types:'',
      word_search: '',
      iterationselected: [],
      discounttypeselected: [],
      sanctionselected: [],
      extraselected: [],
      extrapartselected: [],
    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'extra_sanction';
  },
  methods: {

    Add_new() {

      this.Add(
        {
          type: this.type,
          count: this.counts,
          // staff:this.staffselected,
          extra: this.extraselected,
          extra_part: this.extrapartselected,
          iteration: this.iterationselected,
          discount_type: this.discounttypeselected,
          sanction: this.sanctionselected,


        });


    },


    list(page = 1) {
      this.axios
        .post(`/extra_sanction?page=${page}`)
        .then(({ data }) => {
          // console.log($data);
          this.value_list = data.list;
          this.extra_types = data.extra_types;
          this.discount_types = data.discount_types;
          this.extra_parts = data.extra_parts;
          this.staffs = data.staffs;

        })
        .catch(({ response }) => {
          console.error(response);
        });
    },



  },
};
</script>
