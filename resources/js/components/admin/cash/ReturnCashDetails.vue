<template>
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">

          <span class="h2">تفاصيل مرتجع الصرف</span>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table text-md-nowrap" id="example1">
              <thead>
                <tr>
                  <!-- <th class="wd-15p border-bottom-0">رقم المرتجع</th> -->
                  <th class="wd-15p border-bottom-0">المنتج</th>

                  <th> المواصفات والطراز</th>
                  <th>الحاله</th>
                  <th>المخزن</th>
                  <th>الرف</th>

                  <th class="wd-15p border-bottom-0">الكميه</th>
                  <th class="wd-15p border-bottom-0">المخزن</th>
                  <th class="wd-15p border-bottom-0"> الرف</th>


                </tr>
              </thead>
              <tbody>
                <tr v-for="cashs in cash">
                  <!-- <td>{{ cashs.cash_return_id }}</td> -->
                  <td>{{ cashs.product_name }}</td>
                  <td>{{ cashs.desc }}</td>
                  <td>{{ cashs.name }}</td>
                  <td>{{ cashs.text }}</td>
                  <td>{{ cashs.qty }}</td>
                  <td>{{ cashs.store }}</td>


                </tr>
                <!-- <a 
                      @click="$router.go(-1)"
                      class="btn btn-success"
                      ><span> تراجع</span></a
                    > -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      cash: "yes",
    };
  },
  mounted() {
    this.table = 'cash_return_details';
    let uri = `/returncash_details/${this.$route.params.id}`;
    this.axios.post(uri,{id:this.$route.params.id}).then((response) => {
      this.cash = response.data.return_details;


    });
  },
  methods: {

  },
};
</script>


