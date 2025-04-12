<template>
  <!-- row opened -->

  <div class="container-fluid">
    <div class="card">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between">
          <span class="h2">المنتجات</span>
        </div>
      </div>

      <div class="card-body">
        <div class="row row-sm">

          <div class="col-xl-12">
            <div class="card">
              <!-- <div class="card-header pb-0">


                <span style="font-size: x-large"> شجره المنتجات</span>

              </div> -->
              <div class="card-body">

                  <div class="row justify-content-left">
                    <div class="col-md-12">
                      <div class="card">




                        <div class="card-body">


                          <div class="container-fluid">
                            <div class="row">
                              <div class="col-md-8">

                                <input style="background-color:azure;" class="form-control" type="text"
                                  id="ricerca-enti" placeholder="بحث" aria-describedby="search-addon">



                              </div>


                              <div class="col-md-4">

                                <button @click="exports_excel()">

                                  <i class="fa-solid fa-file-export " style="font-size: 24px; color: #63E6BE;"></i>
                                </button>

                                <button @click="imports_excel()">

                                  <i class="fa-solid fa-file-import " style="font-size: 24px; color: #B197FC;"></i>
                                </button>




                                <!-- <button @click="exports_excel()">
                                  <i class="fas fa-file-export" style="font-size: 24px; color: #ee335e"></i>
                                </button>

                                <button @click="imports_excel()">
                                  <i class="fas fa-file-import" style="font-size: 24px; color: #22c03c"></i>
                                </button> -->

                              </div>




                            </div>
                            <div class="row">
                              <div class="col-xs-12" id="treeview_json_product">

                                <div id="test">

                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
              

              </div>
            </div>
          </div>




          <div class="col-xl-12">
            <div class="card">

              <!-- <div class="card-header">
                <span style="font-size: x-large"> اضافه المنتجات</span>
              </div> -->
              <!-- <form method="post"> -->

              <div class="card-body">
                <div class="row">

                  <div class="col-md-4">
                    <label for="Product">رقم المنتج</label>
                    <input style="background-color: beige;" id='product_number' type="text" class="form-control"
                      required readonly />

                  </div>
                  <div class="col-md-4">
                    <label for="Product">اسم المنتج</label>
                    <input style="background-color: beige;" v-model="text" type="text" name="Product" id="product"
                      class="form-control" required /><span style="color:red">{{ error_text[0] }}</span>

                  </div>

                  <div class="col-md-4">
                    <label for="radio-example-one">متفرع </label><br>

                    <input type="checkbox" name='fieldset2' v-model="status" id="status">
                    <input id='parent' type="hidden" />

                    <input id='rank' type="hidden" />

                  </div>
                </div>

                <br>
                <div class="row">

                  <div class="col-md-12" v-if="!status">
                    <div class="row">


                      <div class='col-md-4'>
                        <label for="Product"></label>

                        <label for="Product">الوحده الرئيسيه<span style="color: red;">(اصغر وحده)</span></label>

                        <select style="background-color: beige;" v-model="unit" class="form-control">
                          <option v-for="unit in units" v-bind:value="unit.id">
                            {{ unit.name }}
                          </option>
                        </select>

                      </div>
                      <div class='col-md-2'>
                        <label for="purchase_price"> سعر الشراء</label>
                        <input v-model="purchase_price" type="text" name="purchase_price" class="form-control" /><span
                          style="color:red">{{ error_purchase_price[0] }}</span>

                        <!-- <input v-model="rate[0]" type="text" 
                          class="form-control" /> -->
                      </div>




                      <div class="col-md-2">
                        <label for="radio-example-one">تعدد وحدات التجزئه </label><br>

                        <input type="checkbox" name='fieldset2' v-model="multi_unit" id="status">
                        <input id='parent' type="hidden" />

                        <input id='rank' type="hidden" />

                      </div>


                      <!-- <div class='col-md-2'>
                        <label for="radio-example-one">اضافه وحدات تجزئه </label><br>


               

                        <button type="button" class="btn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal"
                          data-target="#exampleModalUnit">
                          <i class="fa fa-eye"></i></button>






                      </div> -->





                    </div>

                    <br>

                    <div class="row">

                      <div class='col-md-4'>
                        <label for="Product"></label>

                        <label for="Product">نوع المنتح</label>

                        <select style="background-color: beige;" v-model="product_type" class="form-control">
                          <option v-bind:value="1">

                            فردي
                          </option>
                          <option v-bind:value="2">
                            متباين
                          </option>
                        </select>

                      </div>
                      <div class="col-md-4" v-if="product_type == 2">
                        <label for="pagoPrevio">مجموعه الخصائص</label>

                        <select style="background-color: beige;" @change="get_attribute()" v-model="family_attribute"
                          name="Category" id="Category" class="form-control">
                          <option v-for="families in attribute_families" v-bind:value="families.id">
                            {{ families.name }}
                          </option>



                        </select>

                      </div>

                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-4">
                        <label for="Product Minimum"> الحد الادني للمنتج</label>
                        <input v-model="product_minimum" type="number" name="Minimum" class="form-control" />
                        <span style="color:red">{{ error_hash_rate[0] }}</span>
                      </div>

                      <div class="col-md-4">
                        <label for="Product Minimum">مده الارجاع</label>
                        <input v-model="period" type="number" name="Minimum" class="form-control" />

                      </div>

                      <div class="col-md-4">
                        <label for="filePhoto">الصوره</label>
                        <input v-on:change="onFileChange" type="file" name="image" class="form-control-file"
                          id="filePhoto" />
                        <img src="" id="previewHolder" width="150px" />
                      </div>



                    </div>

                  </div>





                </div>


                <fieldset class="border rounded-3 p-3" v-if="multi_unit">
                  <legend class="float-none w-auto px-3"> وحدات التجزئه</legend>
                  <div class="col-md-12">



                    <div class="table-responsive">
                      <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                        <thead>
                          <tr>
                            <!-- <th>Code</th> -->
                            <th>وحده التجزئه</th>
                            <th>سعر الشراء</th>
                            <th>عدد وحدات التجزئه بالوحده الاساسيه</th>

                            <th>اضافه</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="index in count" :key="index">
                            <td>

                              <!-- retail_unit -->
                              <select v-model="retail_unit[index]" class="form-control">
                                <option v-for="unit in units" v-bind:value="unit.id">
                                  {{ unit.name }}
                                </option>
                              </select>





                            </td>
                            <td>


                              <input v-model="purchase_price_for_retail_unit[index]" type="text" name="purchase_price"
                                class="form-control" />




                            </td>

                            <td>


                              <input v-model="hash_rate[index]" type="text" name="purchase_price"
                                class="form-control" />

                            </td>


                            <td v-if="index == 1">

                              <button class="btn btn-info btn-sm waves-effect btn-agregar"
                                v-on:click="addComponent(count)">
                                <i class="fa fa-plus-circle"></i></button>

                              <button class="btn btn-info btn-sm waves-effect btn-agregar"
                                v-on:click="disComponent(count)">
                                <i class="fa fa-minus-circle"></i></button>



                            </td>
                          </tr>


                        </tbody>
                      </table>
                    </div>





                  </div>


                </fieldset>


                <fieldset class="border rounded-3 p-3" v-if="!status && product_type == 2">
                  <legend class="float-none w-auto px-3">خصائص المنتج</legend>
                  <div class="col-md-12">


                    <form enctype="multipart/form-data">

                      <!-- <form action="post" @submit.prevent="submitForm" enctype="multipart/form-data"> -->

                      <div class="table-responsive">
                        <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                          <thead>
                            <tr>
                              <th>السعر</th>


                              <th>الخصائص</th>
                              <th>صوره المنتج</th>
                              <th>الوصف</th>
                              <th>اضافه</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="index in count" :key="index">


                              <td>
                                <input v-model="price[index - 1]" type="text" class="form-control" name="name" id="name"
                                  required />
                              </td>


                              <td>

                                <div v-for="(atta, index1) in attributes">


                                  <div v-for="(atta2, index2) in atta.attribute_family_mapping" class="col-md-12">
                                    <label for="pagoPrevio"> {{
                                      atta2.attribute.name
                                    }}</label>

                                    <select @change="addFind(index, index2, $event, atta2.id)" class="form-control">
                                      <option v-for="(atta3, index3) in atta2.attribute.attribute_option"
                                        :value="atta3.id">
                                        {{
                                          atta3.value
                                        }}
                                      </option>



                                    </select>
                                  </div>



                                </div>




                              </td>

                              <td>
                                <input type="file" class="form-control" v-on:change="onFileChange($event, index)">


                                <!-- <input v-on:change="onFileChange(index)"
            type="file" name="image"
            class="form-control-file" id="filePhoto">
        <img src="" id="previewHolder" width="150px"> -->
                              </td>


                              <td>
                                <input v-model='description[index - 1]' type="text" class="form-control">


                              </td>


                              <td v-if="index == 1">
                                <a class="tn btn-info btn-sm waves-effect btn-agregar" @click="addComponent(count)">
                                  <i class="fa fa-plus-circle"></i></a>

                                <a class="tn btn-info btn-sm waves-effect btn-agregar" @click="disComponent(count)">
                                  <i class="fa fa-minus-circle"></i></a>
                              </td>



                            </tr>



                          </tbody>
                        </table>
                      </div>
                      <!-- </form> -->



                    </form>




                  </div>


                </fieldset>


                <br>

                <div class="row">

                  <div class="col-md-12">
                    <button type="button" class="btn btn-primary btn-lg btn-inline" @click="add()"> حفظ </button>

                  </div>
                </div>
              </div>
              <!-- <div class="card-footer">
              <button type="button" class="btn btn-primary" @click="addnode()"> حفظ </button>
            </div> -->
              <!-- </form> -->
            </div>
          </div>




          <!--/div-->
        </div>
        <!-- <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <span class="h2">بيانات المنتج</span>


            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>اسم المنتج</th>
                      <th> المواصفات والطراز</th>
                      <th>الحاله</th>
                      <th>المخزن</th>

                      <th class="wd-15p border-bottom-0"> كميه الشراء</th>
                      <th class="wd-15p border-bottom-0"> السعر </th>
          


                    </tr>
                  </thead>
                  <tbody v-if="purchase_detail && purchase_detail.length > 0">
                    <tr v-for="purchase_details in purchase_detail">
                      <td>{{ purchase_details.product }}</td>
                      <td>{{ purchase_details.desc }}</td>
                      <td>{{ purchase_details.status }}</td>
                      <td>{{ purchase_details.store }}</td>
                      <td>


                        <div v-for="temx in purchase_details.qty_after_convert['qty']">



                          <span v-for="temx2 in temx">


                            <span style="float: right;">
                              {{ temx2[0] }}
                              <span style="color: red;">
                                {{ temx2[1] }}
                              </span>

                            </span>



                          </span>


                        </div>


                      </td>

                      <td>{{ purchase_details.price }}</td>
                 



                    </tr>
       

                  </tbody>
                  <tbody v-else>
                    <tr>
                      <td align="center" colspan="8">
                        <h3>
                          لايوجد اي مشتريات
                        </h3>
                      </td>
                    </tr>
                  </tbody>

                </table>
              </div>
            </div>
          </div>
        </div>
      </div> -->


      </div>



      <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            حذف
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>

// import jtree from '../../../../js/jtree.js';
import operation from '../../../operation1.js';
import tree from '../../../../js/tree/tree.js';

export default {
  // mixins: [jtree],
  mixins: [tree, operation],

  // mixins: [tree],
  data() {
    return {

      multi_unit:false,
      counts: [],
      count: 1,
      qty: [],
      price: [],
      description: [],
      discount: [],
      attributes: '',
      count_attributes: '',
      attribute_families: '',
      family_attribute: '',

      product_type: 1,
      check_state: '',
      error_text: '',
      error_hash_rate: '',
      error_purchase_price: '',
      units: '',
      unit: '',
      retail_unit: [],
      hash_rate: [],
      purchase_price: '',
      purchase_price_for_retail_unit: [],
      product_minimum: '',
      period: '',
      file: '',
      text: '',
      product: '',
      image: '',
      status: false,
      id: '',
      trees: "",
      errors: "",
      counts: [],
      // add: 0,




    };
  },
  mounted() {
    // this.list();

    console.log('ffhghghhghhghghhg', window.axios.defaults.baseURL);
    this.counts[0] = 1;
    this.type_of_tree = 0;



    this.axios.post('/product/get_family_attribute').then((response) => {
      this.attribute_families = response.data.attribute_families;

    });



    this.axios.post("/unit").then((response) => {
      this.units = response.data.units;

    });
    this.type = 'Stock';
















  },
  created() {
    localStorage.setItem('id', 0);
    localStorage.setItem('rank', 0);
    localStorage.setItem('table', 'product');

    this.showtree('product', 'tree_product');
  },

  methods: {


    onFileChange(e) {
      this.file = e.target.files[0];
    },

    get_attribute() {


      var gf = this;
      this.axios.post('/product/get_attributes',
        {
          id: this.family_attribute
        }).then((response) => {


          console.log(response.data.attributes);
          gf.count_attributes = response.data.count_attributes
          gf.attributes = response.data.attributes;

        })
        .catch(function (error) {
          // currentObj.output = error;
        });

      return

    },

    exports_excel() {

      axios
        .post(`export_product`)
        .then(function (response) {

          toastMessage("تم تصدير المنتجات  ");
          console.log(1);
        })
        .catch(error => {

        });
    },
    imports_excel() {

      axios
        .post(`import_product`)
        .then(function (response) {

          toastMessage("تم استيراد المنتجات  ");
          console.log(1);
        })
        .catch(error => {

        });
    },

    add() {
      var result = this.addnode();
      toastMessage("تم الاضافه بنجاح");

      this.$router.go(0);
    }



  },
};
</script>
