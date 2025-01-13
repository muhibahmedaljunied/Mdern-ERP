<template>
  <div class="container-fluid">
    <div class="row row-sm">

      <div class="col-md-12">

        <div class="card">

          <div class="card-header">

            <span style="font-size: x-large"> تقرير حركه الاصناف </span>

          </div>
          <div class="card-body">
            <div class="row">

              <div class="col-xl-4">
                <div class="card">

                  <div class="card-body">







                    <div class="row">


                      <div class="col-sm-10">
                        <form>
                          <div v-for="(typee, index) in types">
                            <input v-model="typeselected[index]" @change='onreportchange()' type="checkbox" value=''>
                            <label class="checkbox-inline">{{ types[index] }}</label>



                          </div>
                        </form>
                      </div>

                      <div class="col-sm-2">
                        <a @click="Search()" class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal"
                          id="agregar_productos" data-target=".bs-example-modal-sm">
                          <i class="fa fa-search"></i></a>
                        <a @click=" report_style('printme', '')" class="tn btn-info btn-sm waves-effect btn-agregar"
                          data-toggle="modal" id="agregar_productos" data-target=".bs-example-modal-sm">
                          <i class="fa fa-print"></i></a>
                      </div>



                    </div>



                    <!-- <fieldset class="border rounded-3 p-3">
    <div class="row">


      <div class="col-md-5">
        <label for="desde">من <code>X</code> تاريخ</label>
        <input type="date" class="form-control hasDatepicker" id="modal_reporte_venta_inicio"
          name="modal_reporte_venta_inicio" v-model="from_date" onkeypress="return controltag(event)"
          style="background-color: white" />
      </div>
      <div class="col-md-5">
        <label for="hasta">الي <code>X</code> تاريخ</label>
        <input type="date" class="form-control hasDatepicker" id="modal_reporte_venta_final"
          name="modal_reporte_venta_final" v-model="to_date" onkeypress="return controltag(event)"
          style="background-color: white" />
      </div>
      <div class="col-md-2" v-show="showunit">
        <label for="status">الوحده</label>
        <select v-model="unitselected" name="status" id="status" class="form-control">


          <option v-for="units in unit" v-bind:value="[units.id, units.name]">
            {{ units.name }}
          </option>

        </select>
      </div>

    </div>
  </fieldset>
  <fieldset class="border rounded-3 p-3">
    <div class="row">
      <div class="col-md-2" v-show="showoperation">
        <label for="status"> نوع العمليه</label>
        <select v-model="moveselected" class="form-control">
          <option v-bind:value="1">كل العمليات</option>
          <option v-bind:value="2">صرف</option>
          <option v-bind:value="3">توريد</option>
          <option v-bind:value="4">مرتجع صرف</option>
          <option v-bind:value="5">مرتجع توريد</option>
          <option v-bind:value="6"> بيع</option>
          <option v-bind:value="7">شراء</option>
          <option v-bind:value="8">مرتجع بيع</option>
          <option v-bind:value="9">مرتجع شراء</option>

        </select>
      </div>

      <div class="col-md-3" v-show="showstore">
        <label for="status">المخزن</label>


        <div class="custom-search">
          <input :id="'Movement_store_tree' + index" type="text" readonly class="custom-search-input">
          <input :id="'Movement_store_tree_id' + index" type="hidden" readonly class="custom-search-input">
          <button @click="detect_index_store(index)" class="custom-search-botton" type="submit"
            data-toggle="modal" data-target="#exampleModalStore"> <i class="fa fa-plus-circle"></i></button>
        </div>
      </div>

      <div class="col-md-3" v-show="showproduct">
        <label for="status">المنتج</label>

        <div class="custom-search">

          <input :id="'Movement_product_tree' + index" type="text" readonly class="custom-search-input">
          <input :id="'Movement_product_tree_id' + index" type="hidden" readonly class="custom-search-input">

          <button @click="detect_index(index)" class="custom-search-botton" type="submit" data-toggle="modal"
            data-target="#exampleModalProduct"> <i class="fa fa-plus-circle"></i></button>
        </div>
      </div>
      <div class="col-md-2" v-show="showstatus">
        <label for="status">حاله المنتج</label>
        <select v-model="statusselected" name="status" id="status" class="form-control">


          <option v-for="statuses in status" v-bind:value="[statuses.id, statuses.name]">
            {{ statuses.name }}
          </option>

        </select>
      </div>

      <div class="col-md-2" v-show="showdesc">
        <label for="status">المواصفات والطراز </label>
        <input type="text" v-model="descselected" class="form-control input_cantidad"
          onkeypress="return valida(event)" />
      </div>


    </div>

  </fieldset> -->



                  </div>


                </div>
              </div>
              <div class="col-xl-8">






                <div class="card">

                  <div class="card-body">

                    <div class="row">


                      <div class="col-md-3" v-show="showstore">
                        <label for="status">المخزن</label>


                        <div class="custom-search">
                          <input :id="'Movement_store_tree' + index" type="text" readonly class="custom-search-input">
                          <input :id="'Movement_store_tree_id' + index" type="hidden" readonly
                            class="custom-search-input">
                          <button @click="detect_index_store(index)" class="custom-search-botton" type="submit"
                            data-toggle="modal" data-target="#exampleModalStore"> <i
                              class="fa fa-plus-circle"></i></button>
                        </div>
                      </div>

                      <div class="col-md-3" v-show="showproduct">
                        <label for="status">المنتج</label>

                        <div class="custom-search">

                          <input :id="'Movement_product_tree' + index" type="text" readonly class="custom-search-input">
                          <input :id="'Movement_product_tree_id' + index" type="hidden" readonly
                            class="custom-search-input">

                          <button @click="detect_index(index)" class="custom-search-botton" type="submit"
                            data-toggle="modal" data-target="#exampleModalProduct"> <i
                              class="fa fa-plus-circle"></i></button>
                        </div>
                      </div>



                    </div>
                    <br>
                    <br>
                    <div class="row">


                      <div class="col-md-2">
                        <label for="desde">من <code>X</code> تاريخ</label>
                        <input type="date" class="form-control hasDatepicker" id="modal_reporte_venta_inicio"
                          name="modal_reporte_venta_inicio" v-model="from_date" onkeypress="return controltag(event)"
                          style="background-color: white" />
                      </div>
                      <div class="col-md-2">
                        <label for="hasta">الي <code>X</code> تاريخ</label>
                        <input type="date" class="form-control hasDatepicker" id="modal_reporte_venta_final"
                          name="modal_reporte_venta_final" v-model="to_date" onkeypress="return controltag(event)"
                          style="background-color: white" />
                      </div>
                      <div class="col-md-2" v-show="showoperation">
                        <label for="status"> نوع العمليه</label>
                        <select v-model="moveselected" class="form-control">
                          <option v-bind:value="[1,'all']">كل العمليات</option>
                          <option v-bind:value="[2,'App\\Models\\Cash']">صرف</option>
                          <option v-bind:value="[3,'App\\Models\\Supply']">توريد</option>
                          <option v-bind:value="[4,'App\\Models\\CashReturn']">مرتجع صرف</option>
                          <option v-bind:value="[5,'App\\Models\\SupplyReturn']">مرتجع توريد</option>
                          <option v-bind:value="[6,'App\\Models\\Sale']"> بيع</option>
                          <option v-bind:value="[7,'App\\Models\\Purchase']">شراء</option>
                          <option v-bind:value="[8,'App\\Models\\SaleReturn']">مرتجع بيع</option>
                          <option v-bind:value="[9,'App\\Models\\PurchaseReturn']">مرتجع شراء</option>

                        </select>
                      </div>

                      <div class="col-md-2" v-show="showstatus">
                        <label for="status">حاله المنتج</label>
                        <select v-model="statusselected" name="status" id="status" class="form-control">


                          <option v-for="statuses in status" v-bind:value="[statuses.id, statuses.name]">
                            {{ statuses.name }}
                          </option>

                        </select>
                      </div>

                      <div class="col-md-2" v-show="showdesc">
                        <label for="status">المواصفات والطراز </label>
                        <input type="text" v-model="descselected" class="form-control input_cantidad"
                          onkeypress="return valida(event)" />
                      </div>


                    </div>

                  </div>
                </div>












              </div>
            </div>


            <div class="row row-sm">
              <div class="col-xl-12">
                <div class="card">

                  <div class="card-body">







                    <div class="row" id="printme">
                      <div class="col-sm-12">
                        <div class="card-box">

                          <div class="invoice-box">
                            <!-- --------------------------------------------------------------------------------------------------------------------------------- -->


                            <div class="row">

                              <div class="col-md-6">

                                <span class="h5"> <label style="color: gray; font-size: large;"> من تاريخ</label> :{{
                                  from_date
                                }}



                                </span>

                              </div>

                              <div class="col-md-6">

                                <span class="h5">

                                  <label for="" style="color: gray; font-size: large;"> الي تاريخ</label>
                                  :{{
                                    to_date
                                  }}</span>

                              </div>

                            </div>



                            <div class="row">

                              <div class="col-md-3">

                                <span v-if="productselected != 0" class="h5">
                                  <lable style="color: gray; font-size: large;">المنتج</lable> :
                                  {{ productselectedname }}

                                </span>


                              </div>

                              <div class="col-md-3">



                                <span v-if="moveselected != 0" class="h5">
                                  <lable style="color: gray;font-size: large;">نوع العمليه</lable> :
                                  {{ movement_of_type_operation[moveselected] }}

                                </span>


                              </div>

                              <div class="col-md-2">




                                <span v-if="statusselected != 0" class="h5">
                                  <lable style="color: gray;font-size: large;">الحاله</lable> : {{ statusselected[1]
                                  }}

                                </span>


                              </div>

                              <div class="col-md-2">



                                <span v-if="storeselected != 0" class="h5">
                                  <lable style="color: gray;font-size: large;">المخزن</lable> :
                                  {{ storeselectedname }}

                                </span>

                              </div>

                              <!-- <div class="col-md-2">

                          <h5 v-if="unitselected != 0">
                            الوحده :
                            <span>{{ unitselected[1] }} </span>
                          </h5>
                        </div> -->

                              <div class="col-md-2">




                                <span v-if="descselected != 0" class="h5">
                                  <lable style="color: gray;font-size: large;">المواصفات والطراز</lable> :
                                  {{ descselected }}

                                </span>


                              </div>

                            </div>

                            <br>
                            <br>


                            <div class="table-responsive">

                              <table class="table text-md-nowrap" id="example1">
                                <thead>
                                  <tr class="heading" style="font-size:large">
                                    <td>الرقم التسلسلي</td>
                                    <!-- <td v-if="productselected == 0">المنتج</td> -->
                                    <td>المنتج</td>
                                    <td>اسم المورد او العميل</td>


                                    <td v-if="moveselected == 0">نوع العمليه</td>

                                    <td v-if="storeselected == 0">المخزن</td>
                                    <td v-if="statusselected == 0">الحاله</td>

                                    <!-- <td v-if="descselected == 0">الطراز والمواصفات</td> -->
                                    <td>الطراز والمواصفات</td>



                                    <td>الكميه</td>
                                    <td>التاريخ</td>
                                  </tr>
                                </thead>

                                <tbody>
                              
                                  <tr class="item" v-for="(datas, index) in report.data" :key="index">

                                    <td>{{ index + 1 }}</td>
                                    <td>
                                      {{ datas.product }}
                                    </td>
                                    <td v-if="datas.customer_name">
                                      {{ datas.customer_name }}
                                    </td>
                                    <td v-if="datas.supplier_name">
                                      {{ datas.supplier_name }}
                                    </td>


                                    <div v-if="moveselected == 0">

                                 
                                      <td v-if="datas.stockable_type == 'App\\Models\\Purchase'">
                                        شراء
                                      </td>
                  



                                    </div>
                                    <td v-if="storeselected == 0">{{ datas.store }}</td>
                                    <td v-if="statusselected == 0">{{ datas.name }}</td>

                                    <!-- <td v-if="descselected == 0">{{ datas.desc }}</td> -->
                                    <td>{{ datas.desc }}</td>


                                    <td>{{ datas.quantity }}</td>
                                    <td>{{ datas.date }}</td>
                                  </tr>
                                </tbody>

                              </table>

                            </div>
                          </div>

                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="card-footer">
                    <div id="intro" style="text-align: left">

                      <h3>امين المخازن:{{ user }}</h3>
                      <h5>{{ timestamp }}</h5>
                    </div>
                  </div>

                </div>
              </div>
            </div>

          </div>
        </div>

      </div>

    </div>

    <!-- <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">

          <div class="card-body">




            <fieldset class="border rounded-3 p-3">
              <div class="row">


                <div class="col-md-5">
                  <label for="desde">من <code>X</code> تاريخ</label>
                  <input type="date" class="form-control hasDatepicker" id="modal_reporte_venta_inicio"
                    name="modal_reporte_venta_inicio" v-model="from_date" onkeypress="return controltag(event)"
                    style="background-color: white" />
                </div>
                <div class="col-md-5">
                  <label for="hasta">الي <code>X</code> تاريخ</label>
                  <input type="date" class="form-control hasDatepicker" id="modal_reporte_venta_final"
                    name="modal_reporte_venta_final" v-model="to_date" onkeypress="return controltag(event)"
                    style="background-color: white" />
                </div>
       

              </div>
            </fieldset>
            <fieldset class="border rounded-3 p-3">
              <div class="row">
                <div class="col-md-2" v-show="showoperation">
                  <label for="status"> نوع العمليه</label>
                  <select v-model="moveselected" class="form-control">
                    <option v-bind:value="1">كل العمليات</option>
                    <option v-bind:value="2">صرف</option>
                    <option v-bind:value="3">توريد</option>
                    <option v-bind:value="4">مرتجع صرف</option>
                    <option v-bind:value="5">مرتجع توريد</option>
                    <option v-bind:value="6"> بيع</option>
                    <option v-bind:value="7">شراء</option>
                    <option v-bind:value="8">مرتجع بيع</option>
                    <option v-bind:value="9">مرتجع شراء</option>

                  </select>
                </div>

                <div class="col-md-3" v-show="showstore">
                  <label for="status">المخزن</label>


                  <div class="custom-search">
                    <input :id="'Movement_store_tree' + index" type="text" readonly class="custom-search-input">
                    <input :id="'Movement_store_tree_id' + index" type="hidden" readonly class="custom-search-input">
                    <button @click="detect_index_store(index)" class="custom-search-botton" type="submit"
                      data-toggle="modal" data-target="#exampleModalStore"> <i class="fa fa-plus-circle"></i></button>
                  </div>
                </div>

                <div class="col-md-3" v-show="showproduct">
                  <label for="status">المنتج</label>

                  <div class="custom-search">

                    <input :id="'Movement_product_tree' + index" type="text" readonly class="custom-search-input">
                    <input :id="'Movement_product_tree_id' + index" type="hidden" readonly class="custom-search-input">

                    <button @click="detect_index(index)" class="custom-search-botton" type="submit" data-toggle="modal"
                      data-target="#exampleModalProduct"> <i class="fa fa-plus-circle"></i></button>
                  </div>
                </div>
                <div class="col-md-2" v-show="showstatus">
                  <label for="status">حاله المنتج</label>
                  <select v-model="statusselected" name="status" id="status" class="form-control">


                    <option v-for="statuses in status" v-bind:value="[statuses.id, statuses.name]">
                      {{ statuses.name }}
                    </option>

                  </select>
                </div>

                <div class="col-md-2" v-show="showdesc">
                  <label for="status">المواصفات والطراز </label>
                  <input type="text" v-model="descselected" class="form-control input_cantidad"
                    onkeypress="return valida(event)" />
                </div>


              </div>

            </fieldset>



          </div>


        </div>
      </div>
    </div> -->




    <div class="modal fade" id="exampleModalProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">


            <div class="well" id="treeview_json_product"></div>


          </div>

        </div>
      </div>
    </div>

    <div class="modal fade" id="exampleModalStore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">


            <div class="well" id="treeview_json_store"></div>


          </div>

        </div>
      </div>
    </div>
  </div>
</template>


<script>
import tree from '../../../../js/tree/tree.js';
import ReportOperation from '../../../../js/ReportOperation.js';
export default {
  mixins: [tree, ReportOperation],
  data() {
    return {

      all_products: '',

      indexselected: '',
      indexselectedproduct: '',
      indexselectedstore: '',
      last_nodes: '',
      rank: 1,
      parent: 0,
      index: 0,

      statusselected: 0,
      unitselected: 0,
      unitselectedname: '',
      productselected: 0,
      productselectedname: "",
      storeselectedname: "",
      storeselected: 0,
      descselected: "",
      operationselected: 0,
      dateselected: 0,
      typeselected: [],
      checkselected: '',
      moveselected: 0,

      name_of_report: 'تقرير حركه الاصناف',
      type: '',
      type_of_tree: 1,
      jsonTreeData: '',
      supplier: "yes",
      product: "",
      store: "",
      status: "",
      user: "",
      unit: '',
      types: [
        'حسب المخزن',
        'حسب المنتج',
        'حسب حاله المنتج',
        'حسب المواصفات والطراز',
        'حسب نوع العمليه',
        // 'حسب الوحده',
      ],
      movement_of_type_operation: [
        '',
        ' كل العمليات',
        'صرف',
        'توريد',
        'مرتجع صرف',
        'مرتجع توريد',
        'بيع',
        'شراء',
        'مرتجع بيع',
        'مرتجع شراء',



      ],
      timestamp: '',
      index: 1,
      // type_report: 0,
      // from_date: "2021-11-24",
      // to_date: new Date().toISOString().substr(0, 10),

      report: {
        type: Object,
        default: null,
      },



      default: 100,
    };
  },
  created() {
    // this.$router.go(0);
    setInterval(this.getNow, 1000);
  },
  mounted() {
    this.type = 'Movement';
    this.showtree('product', 'tree_product');
    this.showtree('store', 'tree_store');
    this.axios.post("/movement_repo").then((response) => {


      this.status = response.data.statuses;
      // this.unit = response.data.unit;
      this.user = response.data.users.name;
    });
  },

  methods: {
    getNow: function () {
      const today = new Date();
      const date =
        today.getFullYear() +
        "-" +
        (today.getMonth() + 1) +
        "-" +
        today.getDate();
      const time =
        today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
      const dateTime = date + " " + time;
      this.timestamp = dateTime;
    },


    onreportchange() {

      (this.typeselected[0] == true) ? this.showstore = true : this.showstore = false;
      (this.typeselected[1] == true) ? this.showproduct = true : this.showproduct = false;
      (this.typeselected[2] == true) ? this.showstatus = true : this.showstatus = false;
      (this.typeselected[3] == true) ? this.showdesc = true : this.showdesc = false;
      (this.typeselected[4] == true) ? this.showoperation = true : this.showoperation = false;
      (this.typeselected[5] == true) ? this.showunit = true : this.showunit = false;



    },

    Search() {
      this.axios
        .post(`/show_repo_movement`, {
          type_operation: this.moveselected,
          store_id: this.storeselected,
          product_id: this.productselected,
          status_id: this.statusselected,
          // unit_id: this.unitselected,
          desc: this.descselected,
          from_date: this.from_date,
          to_date: this.to_date,
        })
        .then((response) => {
          console.log(response.data.repo_movement);
          this.report = response.data.repo_movement;
        });
    },
    // printDiv(printme) {

    //   report_style(printme, '');

    // },
  },
};
</script>

<!-- <style scoped>
.card-header {

  background-color: #00b9ff;
}
</style> -->
