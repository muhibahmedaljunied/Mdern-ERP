<template>
  <!-- row opened -->

  <div class="container-fluid">
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">

            <span class="h2"> بدلات الموظفين</span>
          </div>
          <div class="card-body" id="printme">
            <div class="row">
              <div class="col-md-4">
                <label for="status">اسم الموظف</label>
                <select @change="select_staff" v-model="staff_selected" name="type" id="type" class="form-control "
                  required>
                  <option v-for="staff in staffs" v-bind:value="staff.id">
                    {{ staff.name }}
                  </option>
                </select>
              </div>
              <div class="col-md-2">
                <label for="status"> نوع البدل</label>
                <select @change="select_staff" v-model="staff_selected" name="type" id="type" class="form-control "
                  required>
                  <option v-for="staff in staffs" v-bind:value="staff.id">
                    {{ staff.name }}
                  </option>
                </select>
              </div>
              <!-- <div class="col-md-2">
              <label for="status"> من تأريخ</label>
              <input v-model="from_date" type="date" name="" id="" class="form-control">
            </div>

            <div class="col-md-2">
              <label for="status">الي تأريخ</label>
              <input v-model="into_date" type="date" name="" id="" class="form-control">
            </div> -->
              <!-- <div class="col-sm-6 col-md-3" style="margin-top: auto;">
                <a href="#" @click="report()"><img src="/assets/img/search.png" alt="" style="width: 10%;"> </a>
              </div> -->

              <div class="col-sm-6 col-md-2" style="margin-top: auto;">


<a @click="report()" href="#">

  <i class="fa-solid fa-magnifying-glass fa-2xl" style="color: #74C0FC;"></i>


</a>


</div>
            </div>

          </div>

        </div>
      </div>
      <!--/div-->
    </div>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">

          <div class="card-body" id="printme">
            <div class="row">
              <div class="table-responsive">
                <table class="table table-bordered text-center">
                  <thead>
                    <tr>
                      <!-- <th class="wd-15p border-bottom-0">الرقم الوظيفي</th> -->
                      <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                      <th class="wd-15p border-bottom-0"> البدل</th>
                      <th class="wd-15p border-bottom-0"> نوع البدل</th>
                      <!-- <th class="wd-15p border-bottom-0">التاريخ</th> -->

                      <th class="wd-15p border-bottom-0">المبلغ</th>
                      <th class="wd-15p border-bottom-0" style="color:red">الاجمالي</th>

                      <!-- <th class="wd-15p border-bottom-0"> ملاجظه</th> -->


                      <!-- <th class="wd-15p border-bottom-0">العمليات</th> -->
                    </tr>
                  </thead>
                  <tbody v-if="list_data && list_data.data.length > 0">
                    <tr v-for="(allowance, index) in list_data.data" :key="index">
                      <td>{{ allowance.name }}</td>

                      <td></td>

                      <td>

                          
                    
                      </td>

                      <td>

                        <!-- <div v-for="(adv, index) in advance.advance" :key="index">
                          {{ adv.quantity }}
                          <hr>
                        </div> -->
                      </td>


                      <td style="color:red">

                        {{ allowance.quantity }}
                    
                      </td>

                      <!-- 
                  <td>
                    <button type="button" @click="delete_advance(advance.id)" class="btn btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>

                    <router-link :to="{
                      name: 'edit_advance',
                      params: { id: advance.id },
                    }" class="edit btn btn-success">
                      <i class="fa fa-edit"></i></router-link>
                    <router-link :to="{
                      name: 'edit_advance',
                      params: { id: advance.id },
                    }" class="edit btn btn-success">
                      <i class="fa fa-eye"></i></router-link>
                  </td> -->
                    </tr>
                    <tr>
                      <td colspan="3" style="color:red;font-size: x-large;">الاجمالي</td>

                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr>
                      <td align="center" colspan="3">لايوجد بياتات.</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <pagination align="center" :data="advances" @pagination-change-page="list"></pagination>
            </div>

          </div>

        </div>
      </div>
      <!--/div-->
    </div>
  </div>

  <!-- /row -->
</template>

<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../../staff/StaffData/staff_data.js';

export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {
      // category: "yes",

      list_data: {
        type: Object,
        default: null,
      },
      staff_selected: 1,
      count: 1,
      counts: [],
      quantity: [],
      date: [],
      staffselected: [],
      quantityselected: '',

      table: 'advance',

      staffs: '',
      note: '',

      word_search: "",



      from_date: new Date().toISOString().substr(0, 10),
      into_date: new Date().toISOString().substr(0, 10),
    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'allowance';
  },
  methods: {


    report() {
      this.axios
        .post(`/allowance_report`, {
          type: this.type,
          staff: this.staff_selected,
          from_date: this.from_date,
          into_date: this.into_date,
        })
        .then(({ data }) => {
          this.list_data = data.list;

        });
    },


    list(page = 1) {

      this.axios
        .post(`/allowance?page=${page}`, { type: 'allowance' })
        .then(({ data }) => {
          console.log(data);
 
          this.list_data = data.list


        })
        .catch(({ response }) => {
          console.error(response);
        });
    },






  },
};
</script>
