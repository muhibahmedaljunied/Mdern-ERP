<template>
  <!-- row opened -->
  <div>

    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">
            <span class="h4"> انوع التصنيفات</span>


          </div>
          <div class="card-body">

            <!-- <div class="row">
              <div class="col-xl-2">
                <label for="">الحساب المرتبط </label>

                <div class="custom-search">

                  <input id="Treasury_account_group_tree" type="text" class="custom-search-input">

                  <button class="custom-search-botton" type="button" data-toggle="modal"
                    data-target="#exampleModalTreasury"> <i class="fa fa-plus-circle"></i></button>

                </div>

              </div>
              
              <div class="col-xl-2">
                <label for="">رقم الحساب </label>

                <input type="text"  name="status" id="Treasury_account_group_tree_id"
                  class="form-control" />
              </div>
            </div>
            <br> -->

            <div class="row row-sm">




              <div class="col-xl-12">



                <form method="post" enctype="multipart/form-data">

                  <div class="table-responsive">
                    <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                      <thead>
                        <tr>



                          <th>النوع </th>

                          <th>الكود </th>

                          <th>الحاله </th>




                          <th>اضافه</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="index in count" :key="index">



                          <td>
                            <input style="background-color:beige" v-model="name[index]" type="text" class="form-control"
                              required />

                          </td>

                          <td>
                            <input style="background-color:beige" v-model="code[index]" type="text" class="form-control"
                              required />

                          </td>

                          <td>
                            <select style="background-color:beige" v-model="status[index]"
                              class="form-control " required>
                              <option  v-bind:value="1">
                                مفعل
                              </option>
                              <option  v-bind:value="0">
                                غير مفعل
                              </option>

                            </select>

                          </td>




                          <td v-if="index == 1">
                            <a class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="addComponent(count)">
                              <i class="fa fa-plus-circle"></i></a>

                            <a class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="disComponent(count)">
                              <i class="fa fa-minus-circle"></i></a>
                          </td>



                        </tr>

                        <tr>
                          <td colspan="3"></td>
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

          <div class="modal fade" id="exampleModalTreasury" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <div class="well" id="treeview_json_account_group"></div>

                </div>

              </div>
            </div>
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


              <button @click="exports_excel()">

                <i class="fa-solid fa-file-export " style="font-size: 24px; color: #63E6BE;"></i>
              </button>

              <button @click="imports_excel()">

                <i class="fa-solid fa-file-import " style="font-size: 24px; color: #B197FC;"></i>
              </button>

              <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button"
                aria-haspopup="true" aria-expanded="true" placeholder="بحث " v-model="word_search"
                @input="get_search()" />
            </div>
          </div>
          <div class="card-body" id="printme">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">الرقم </th>
                    <th class="wd-15p border-bottom-0"> النوع</th>
                    <th class="wd-15p border-bottom-0"> الكود</th>

                    <th class="wd-15p border-bottom-0"> الحاله</th>


                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="group_types && group_types.length > 0">
                  <tr v-for="(group, index) in group_types" :key="index">
                    <td>
                      {{ group.id }}
                    </td>
                    <td>
                      {{ group.name }}
                    </td>
                    <td>
                      {{ group.code }}
                    </td>
                    <td v-if="group.status == 0">
                     
                      غير مفعل
                    </td>

                    <td v-else>
                      مفعل
                    </td>
                    <td>
                      <button data-toggle="modal" class="tn btn-danger btn-sm waves-effect btn-agregar">
                        <i class="fa fa-trash"></i></button>

                    </td>






                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="3">
                      <h3> لايوجد بيانات </h3>
                    </td>
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
import tree from '../../../tree/tree.js';
import operation from '../../../operation1.js';


export default {
  mixins: [
    tree,
    operation
  ],
  components: {
    pagination,
  },
  data() {

    return {

      name: [],
      code: [],
      status: [],
      group_types: '',

    }

  },
  mounted() {

    this.list();
    this.counts[0] = 1;
    this.type = 'GroupType';




  },

  methods: {




    Add_new() {

      this.axios
        .post(`/store_group_type`, {

          count: this.counts,
          name: this.name,
          code: this.code,
          status: this.status,



        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");

          this.list();

        });




    },


    list() {
      this.axios
        .post(`/group_types`)
        .then(({ data }) => {


          this.group_types = data.group_types;


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