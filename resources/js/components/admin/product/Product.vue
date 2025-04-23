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


<<<<<<< HEAD
=======
                <span style="font-size: x-large"> شجره المنتجات</span>

              </div> -->
              <!-- <span> *كيف يتم التعامل مع تعدد الوحدات في حاله المنتجات المتباينه وضبط سعر الشراء وسعر البيع وكذلك ضبط
                الاجزاء للوحدات مقارنه مع الانظمه الاخري مثل mazerp
              </span>

              <span> *هل يمكن تفعيل المخازن من الاعدادات في نظام mazerp تأكد لانه في الفيديو هذا موجود
              </span>
              <span>
                *كيف يتم التعامل مع الفروع هل تحدد لاول مره فقط ثم تعين اعتمادا علي ذلك في الواجهات والعمليات وكيف يتم
                ربط الفروع بباقي جداول النظام تتبع smacc @ MazErp 
              </span> -->

>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5
              <div class="card-body">

                <div class="row justify-content-left">
                  <div class="col-md-12">
                    <div class="card">




                      <div class="card-body">


                        <div class="container-fluid">
                          <div class="row">
                            <div class="col-md-8">

                              <input style="background-color:azure;" class="form-control" type="text" id="ricerca-enti"
                                placeholder="بحث" aria-describedby="search-addon">



                            </div>







                          </div>
                          <div class="row">
                            <div class="col-xs-12" id="treeview_json_products">

                              <div id="test">

                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                    <div class="card">
                      <div class="card-body">

                        <div class="row">

                          <div class="col-md-12">

                            <div class="card">


                              <div class="card-body">




<<<<<<< HEAD
=======
                  <div class="col-md-2">
                    <label for="Product">رقم المنتج</label>
                    <input style="background-color: beige;" type="text" id='product_number' class="form-control"
                      required readonly />
>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5


                                <div class="row">

                                  <div class="table-responsive">
                                    <table class="table text-md-nowrap" id="example1">
                                      <thead>

                                        <tr>




                                        </tr>
                                      </thead>
                                      <tbody v-if="showCatProduct && showCatProduct.length > 0">

                                        <tr v-for="(productss, index) in showCatProduct" :key="index">


<<<<<<< HEAD
=======
                        <label for="Product">الوحده الاساسيه<span style="color: red;">(اصغر وحده)</span></label>
>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5

                                          <template>
                                            <div class="row">

<<<<<<< HEAD
                                              <div class="col-md-2">
=======
                      </div>
                      <!-- <div class='col-md-2'>
                        <label for="Product"></label>
>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5

                                                {{ index + 1 }}

                                              </div>
                                              <div class="col-md-2">
                                                {{ productss.text }}

<<<<<<< HEAD
                                                <div class="col-md-12"
                                                  v-for="produc_option in productss['product_family_attribute']">

=======
                      </div> -->
                      <!-- <div class='col-md-2'>
                        <label for="purchase_price"> سعر الشراء</label>
                        <input v-model="purchase_price" type="text" class="form-control" /><span style="color:red">{{
                          error_purchase_price[0] }}</span>

                      </div> -->
                      <div class="col-md-2">
                        <label for="radio-example-one">تعدد وحدات التجزئه </label><br>
>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5

                                                  <span v-for="option in produc_option.family_attribute_option">
                                                    {{ option.value }}
                                                  </span>

                                                </div>

                                              </div>

<<<<<<< HEAD
                                              <div class="col-md-8">
=======
                      <div class='col-md-2'>
                        <label for="purchase_price"> الطراز </label>
                        <input v-model="desc" type="text" class="form-control" /><span style="color:red">{{
                          error_purchase_price[0] }}</span>

                        <!-- <input v-model="rate[0]" type="text" 
                          class="form-control" /> -->
                      </div>


                      <div class='col-md-2'>
                        <label for="Product"></label>

                        <label for="Product">الحاله</label>

                        <select v-model="status_product_selected" name="type" id="type" class="form-control" required>

                          <option v-for="status in status_product" v-bind:value="status.id">
                            {{ status.name }}
                          </option>
                        </select>

                      </div>

>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5

                                                <template
                                                  v-for="product_family in productss['product_family_attribute']">

                                                  <div class="row">

                                                    <div class="row">

                                                      <div class="col-md-4">

                                                        <div class="col-md-12">
                                                          الكميه: {{ product_family.qty }}

                                                        </div>

                                                        <div class="col-md-12">
                                                          السعر:{{ product_family.price }}

                                                        </div>

                                                        <!-- <div class="col-md-12"
                                v-for="option in product_family.family_attribute_option">
                                <p>{{ option.name }}:{{ option.value
                                }}</p>
                              </div> -->
                                                      </div>

                                                      <div class="col-md-2">

                                                        <img class="card-img"
                                                          :src="`/Ecommerce/assets/upload/${product_family.image}`"
                                                          alt="Product Image" height='200px' />



                                                      </div>

                                                      <div class="col-md-6">



                                                        <button type='button' class="btn btn-danger btn-sm"><i
                                                            class="fa fa-trash"></i></button>
                                                        <router-link
                                                          :to="{ name: 'edit_product', params: { data: productss } }"
                                                          class="btn btn-success btn-sm"><i
                                                            class="fa fa-edit"></i></router-link>



<<<<<<< HEAD
=======
                      </div>

>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5


<<<<<<< HEAD
                                                      </div>
=======
                        <select style="background-color: beige;" @change="get_attribute()" v-model="family_attribute"
                          id="Category" class="form-control">
                          <option v-for="families in attribute_families" v-bind:value="families.id">
                            {{ families.name }}
                          </option>
>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5


                                                    </div>


                                                  </div>

<<<<<<< HEAD

=======
                      <div class="col-md-2">
                        <label for="Product Minimum"> الحد الادني للمنتج</label>
                        <input v-model="product_minimum" type="number" class="form-control" />
                        <span style="color:red">{{ error_hash_rate[0] }}</span>
                      </div>

                      <div class="col-md-2">
                        <label for="Product Minimum">مده الارجاع</label>
                        <input v-model="period" type="number" class="form-control" />
>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5

                                                </template>

<<<<<<< HEAD
                                              </div>

=======
                      <div class="col-md-2" v-if="product_type == 1">
                        <label for="filePhoto">الصوره</label>
                        <input v-on:change="onFileChange" type="file" class="form-control-file" />
                        <img src="" id="previewHolder" width="150px" />
                      </div>

                    </div>


>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5



                                            </div>
                                            <hr>
                                          </template>

                                        </tr>

<<<<<<< HEAD
                                      </tbody>
                                      <tbody v-else>
                                        <tr>
                                          <td style="text-align: center;" colspan="7">
                                            لايوجد اي بيانات
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
=======

                </div>


                <fieldset class="border rounded-3 p-3" v-if="multi_unit">
                  <legend class="float-none w-auto px-3"> وحدات التجزئه</legend>
                  <div class="col-md-12">



                    <div class="table-responsive">
                      <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                        <thead>
                          <tr>
                            <!-- <th>Code</th> -->
                            <th>الرقم التسلسلي</th>
                            <th>وحده التجزئه</th>
                            <!-- <th>سعر الشراء</th> -->
                            <th>عدد وحدات التجزئه بالوحده الاساسيه</th>

                            <th>اضافه</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="index in count_unit" :key="index">
                            <td>
                              {{ index }}
                            </td>
                            <td>

                              <!-- retail_unit -->
                              <select v-model="retail_unit[index]" class="form-control">
                                <option v-for="unit in units" v-bind:value="unit.id">
                                  {{ unit.name }}
                                </option>
                              </select>





                            </td>
                            <!-- <td>


                              <input v-model="purchase_price_for_retail_unit[index]" type="text" 
                                class="form-control" />




                            </td> -->

                            <td>


                              <input v-model="hash_rate[index]" type="text" class="form-control" />

                            </td>


                            <td v-if="index == 1">

                              <button class="btn btn-info btn-sm waves-effect btn-agregar"
                                v-on:click="addComponentUnit(count_unit)">
                                <i class="fa fa-plus-circle"></i></button>

                              <button class="btn btn-info btn-sm waves-effect btn-agregar"
                                v-on:click="disComponentUnit(count_unit)">
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
                              <th>الرقم التسلسلي</th>
                              <!-- <th>السعر</th> -->


                              <th>الخصائص</th>
                              <th>صوره المنتج</th>
                              <th>الوصف</th>
                              <th>اضافه</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="index in count" :key="index">


                              <td>
                                {{ index }}
                              </td>
                              <!-- <td>
                                <input v-model="price[index - 1]" type="text" class="form-control" name="name" id="name"
                                  required />
                              </td> -->


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
>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5
                                  </div>
                                </div>

                              </div>
                            </div>

                          </div>


<<<<<<< HEAD
=======
                              </td>

                              <td>
                                <input type="file" class="form-control" v-on:change="onFileChange($event, index)">


                                <!-- <input v-on:change="onFileChange(index)"
            type="file" 
            class="form-control-file" >
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

>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5

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
  </div>
</template>

<script>


import operation from '../../../operation1.js';
import tree from '../../../tree/tree.js';

export default {
  mixins: [tree, operation],

  data() {
    return {
      products: '',

      showCatProduct: '',

      product: '',
      qty: [],
      price: [],
      desc:'',
      description: [],
      attr_array: [],
      discount: [],
<<<<<<< HEAD
      word_search: '',
      New: '',
      featured: '',
      status: '',
      image: '',
      categoryselected: '',
      parentselected: 0,
      jsonTreeData: '',
      attribute_families: '',
      family_attribute: '',
      attributes: '',
      attr_array: [],
      att_family: '',
      // att_all_family: [],
      product_id: '',
      errors: '',
      success: '',
      // filename: '',
=======
      attributes: '',
      attribute_families: '',
      family_attribute: '',
      count_attributes: 1,
      product_type: 1,
      check_state: '',

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
      // file: '',
      file: [],
      text: '',
      product: '',
      image: '',
      status: false,
      status_product:'',
      status_product_selected:'',
      id: '',
      trees: "",
      errors: "",
>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5
      counts: [],
      count: 1,
      count_attributes: 1,
      file: [],

    }
  },
  mounted() {
<<<<<<< HEAD
=======
    // this.list();

    console.log('ffhghghhghhghghhg', window.axios.defaults.baseURL);
    this.counts[0] = 1;
    this.type_of_tree = 0;



    this.axios.post('/product/get_family_attribute').then((response) => {
      this.attribute_families = response.data.attribute_families;

    });



    this.axios.post("/unit").then((response) => {
      this.units = response.data.units;
      this.status_product = response.data.status;

    });
    this.type = 'Stock';



    this.att_family = Array.from(Array(this.count), () => new Array(this.count_attributes))
    console.log('kkkkkkkk', this.att_family);












>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5


    this.att_family = Array.from(Array(this.count), () => new Array(this.count_attributes))

    this.axios.post('/show_product').then(response => {

      console.log(response.data.product);
      this.showCatProduct = response.data.product;
      // this.$root.logo = 'Product'

    })
  },
  created() {

    this.showtree('products', 'tree_product');
  },

  methods: {

<<<<<<< HEAD

=======
    addComponentUnit(index) {
      // alert(index);
      this.count_unit += 1;
      this.counts_unit[index] = this.count_unit;
    },
    disComponentUnit(index) {
      if (index != 1) {
        this.count_unit -= 1;
        this.$delete(this.counts_unit, index - 1);
        console.log("yuuyyusd", index, this.count_unit);
      }
    },

    addComponent(index) {
      // alert(index);
      this.count += 1;
      this.counts[index] = this.count;

      this.att_family = Array.from(Array(this.count), () => new Array(2))
      console.log('kkkkkkkk_addComponentUnit', this.att_family);
    },
    disComponent(index) {
      if (index != 1) {
        this.count -= 1;
        this.$delete(this.counts, index - 1);
        console.log("yuuyyusd", index, this.count);
      }
    },

    addFind(index, index2, event, att) {


      index = index - 1;
      console.log(index, index2);
      this.att_family[index][index2] = [att, event.target.value];

    },

    onFileChange(e) {
      this.file = e.target.files[0];
    },
    onFileChange(e, index) {


      this.file[index] = e.target.files[0];
      console.log(this.file);
    },
>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5

    get_attribute() {


      var gf = this;
      this.axios.post('/product/get_attributes',
        {
          id: this.family_attribute
        }).then(function (response) {


          console.log(response.data.attributes);
          gf.count_attributes = response.data.count_attributes
          gf.attributes = response.data.attributes;

        })
        .catch(function (error) {
          // currentObj.output = error;
        });

      return

    },





<<<<<<< HEAD
=======
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

      // this.$router.go(0);
    }
>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5



  },
};







</script>
<style>
legend {

  font-weight: lighter;
  color: cadetblue;
}
</style>
