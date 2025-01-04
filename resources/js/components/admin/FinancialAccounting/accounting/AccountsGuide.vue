<template>
  <div class="card">
    <div class="card-header pb-0">
      <div class="d-flex justify-content-between">
        <span class="h2"> الدليل المحاسبي</span>
      </div>
    </div>
    <div class="card-body">
      <div class="row row-sm">
        <div class="col-xl-6">
          <div class="card">
            <div class="card-header pb-0">


              <span style="font-size: x-large"> شجره الحسابات</span>
              <!-- <router-link to="create_product" id="agregar_productos"
                class="tn btn-info btn-lg waves-effect btn-agregar"><i class="fa fa-plus-circle"></i></router-link> -->



            </div>
            <div class="card-body">
              <div class="container">
                <div class="row justify-content-left">
                  <div class="col-md-12">
                    <div class="card">



                      <div class="card-body">


                        <div class="container">
                          <div class="row">
                            <div class="col-md-8">

                              <input style="background-color:azure;" class="form-control" type="text" id="ricerca-enti" placeholder="بحث"
                                aria-describedby="search-addon">



                            </div>


                            <div class="col-md-4">



                              <button class="btn btn-primary btn-sm btn-inline" type="button"
                                @click="imports_excel()">استيراد</button>
                              <button class="btn btn-primary btn-sm btn-inline" type="button"
                                @click="exports_excel()">تصدير</button>



                            </div>




                          </div>
                          <div class="row">
                            <div class="col-xs-12" id="treeview_json_account">

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
        </div>

        <div class="col-xl-6">


          <div class="container">
            <div class="row justify-content-left">
              <div class="col-md-12">
                <div class="card">

                  <div class="card-header pb-0">


                    <span style="font-size: x-large">اضافه حساب</span>


                  </div>

                  <form method="post">

                    <div class="card-body">
                      <div class="row">


                        <div class="col-md-4">
                          <label for="Product">رقم الحساب</label>
                          <input id='account_number' type="text" class="form-control" required />

                        </div>

                        <div class="col-md-4">
                          <label for="Product">اسم الحساب</label>
                          <input v-model="text" type="text" name="Product" id="account_first_level" class="form-control"
                            required />

                        </div>


                      </div>

                      <br>

                      <div class="row">

                        <div class="col-md-6">

                          <label for="FormaPago"> الحساب الختامي</label>
                          <select v-model="final_account" class="form-control" style="background-color: beige;"
                            name="forma_pago" id="forma_pago">

                            <option v-bind:value="1">ميزانيه</option>
                            <option v-bind:value="2">ارباح وخساير</option>

                            <option v-bind:value="3">متاجره</option>
                            <option v-bind:value="4"> تشغيل</option>
                          </select>





                        </div>







                      </div>

                      <br>
                      <div class="row">


                        <div class="col-md-4">


                          <label for="FormaPago"> طبيعه الحساب</label>
                          <select class="form-control" v-model="account_type_debit_credit"
                            style="background-color: beige;" name="forma_pago" id="forma_pago">

                            <option v-bind:value="1">مدين</option>
                            <option v-bind:value="2"> داين</option>


                          </select>





                        </div>

                        <div class="col-md-4">


                          <label for="FormaPago"> نوع الحساب</label>
                          <select class="form-control" v-model="account_type" style="background-color: beige;"
                            name="forma_pago" id="forma_pago">

                            <option v-bind:value="1">اصول ثابته</option>
                            <option v-bind:value="2"> اصول متداوله</option>
                            <option v-bind:value="3"> خصوم ثابته</option>
                            <option v-bind:value="4"> خصوم متداوله</option>
                            <option v-bind:value="5"> حقوق الملكيه</option>
                            <option v-bind:value="6"> مصروفات </option>
                            <option v-bind:value="7"> ايرادات </option>



                          </select>





                        </div>

                        <div style="text-align: center;" class="col-md-2">
                          <label for="FormaPago"> متفرع</label>

                          <input class="btn btn-lg btn-block" type="checkbox" name='fieldset2' v-model="status_account"
                            id="status" />
                            <input id='parent' type="hidden" />
                          <input id='rank' type="hidden" />
                        </div>


                      </div>
                      <br>
                      <div class="row">



                        <div class="col-md-12">


                          <button type="button" class="btn btn-primary btn-sm btn-inline" @click="addnode_account"> حفظ
                          </button>
                        </div>
                      </div>


                    </div>
                    <!-- <div class="card-footer">
                      <button type="button" class="btn btn-primary btn-lg btn-block" @click="addnode"> حفظ </button>
                    </div> -->
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>


      </div>

      <!-- <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <span class="h2">تفاصيل المنتجات</span>


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
  </div>
</template>
<script>


import tree from '../../../../../js/tree/tree.js';
export default {
  mixins: [tree],
  data() {
    return {
      file: '',
      table: '',
      text: '',
      status: false,
      status_account: false,
      account_type: '',
      account_type_debit_credit: '',
      id: 0,
      trees: "",
      errors: "",
      final_account: '',

      add: 0,
      // type_of_tree:0,
    };
  },


  created() {
    this.type_of_tree = 0;
    this.type = 'account';
    localStorage.setItem('id', 0);
    localStorage.setItem('rank', 0);
    localStorage.setItem('table', 'account');

    this.showtree('account', 'tree_account');
  },
  methods: {

    update_account(e) {
      e.preventDefault();
      updatenode($("#update_account_number").val(), this.text);
    },


    exports_excel() {

      axios
        .post(`export_account`)
        .then(function (response) {

          // console.log(1);
        })
        .catch(error => {

        });
    },
    imports_excel() {

      axios
        .post(`import_account`)
        .then(function (response) {

          // console.log(1);
        })
        .catch(error => {

        });
    },


  },
};
</script>
