<template>
  <!-- row opened -->
  <div class="container-fluid">

    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">
            <span class="h4"> اضافه صندوق</span>


          </div>
          <div class="card-body">

      

            <div class="row row-sm">




              <div class="col-xl-12">



                <form method="post" >

                  <div class="table-responsive">
                    <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                      <thead>
                        <tr>

                          <th>الرقم التسلسلي </th>

                          <th>الصندوق </th>

                          <th>
                          الفرع
                          </th>

                          <!-- <th> التصنيف </th> -->


                          <!-- <th> العمله </th> -->

                          <th>اضافه</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="index in count" :key="index">

                          <td>
                            {{ index }}
                          </td>
                          <td>
                            <input v-model="treasury[index]" type="text" class="form-control" name="name" id="name"
                              required />
                          </td>

                          <td>
                            <select style="background-color: beige;" v-model="branchselected" class="form-control" required>
                        <option v-for="branch in branches" v-bind:value="branch.id">
                          {{ branch.name }}
                        </option>
                      </select>
                          </td>


                          <!-- <td>
                            <select style="background-color:beige" v-model="group_selected[index]"
                              class="form-control " required>
                              <option v-for=" group_type in groups" v-bind:value="group_type.id">
                                {{ group_type.name }}
                              </option>

                            </select>

                          </td> -->


                          <!-- <td>
                            <input v-model="currency[index]" type="text" class="form-control" name="name" id="name"
                              required />
                          </td> -->






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
              aria-haspopup="true" aria-expanded="true" placeholder="بحث عن صندوق" v-model="word_search"
              @input="get_search()" />
          </div>
        </div>
          <div class="card-body" >
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">الرقم التسلسلي</th>
                    <th class="wd-15p border-bottom-0"> الصندوق</th>
                    <!-- <th class="wd-15p border-bottom-0"> التصنيف</th> -->



                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="treasuries && treasuries.data.length > 0">
                  <tr v-for="(treasury, index) in treasuries.data" :key="index">
                    <td>
                      {{ index+1 }}
                    </td>
                    <td>
                      {{ treasury.name }}
                    </td>
                    <!-- <td>
                      {{ treasury.group_name }}
                    </td> -->
                    <!-- <td>
                      {{ treasury.text }} {{ treasury.account_id }}
                    </td> -->

                    <td>
                      <button data-toggle="modal" class="tn btn-danger btn-sm waves-effect btn-agregar">
                        <i class="fa fa-trash"></i></button>
                        
                        <button class="btn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal"
                             data-target="#updateTreasury">
                            <i class="fa fa-edit"></i></button>

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
import operation from '../../../../operation1.js';


export default {
  mixins: [
    operation
  ],
  components: {
    pagination,
  },
  data() {

    return {
      treasuries: {
        type: Object,
        default: null,
      },
      treasury: [],
      currency: [],
      // group_selected: [],
      // groups: '',

      currency: [],



      // indexselectedtreasury: 0,
      type: '',

    }
    // return data;
  },
  mounted() {

    this.list();
    this.counts[0] = 1;
    this.type = 'Treasury';




  },

  methods: {




    Add_new() {

      this.axios
        .post(`/store_treasury`, {
          count: this.counts,
          type: this.type,
          name: this.treasury,
          // account: this.account,
          // group: this.group_selected,



        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          this.list();
          // this.$router.go(0);
        });




    },


    list(page = 1) {
      this.axios
        .post(`/treasuries?page=${page}`)
        .then(({ data }) => {
          console.log(data);



          this.treasuries = data.treasuries;
          // this.groups = data.groups;


        })
        .catch(({ response }) => {
          console.error(response);
        });
    },


  },
};
</script>