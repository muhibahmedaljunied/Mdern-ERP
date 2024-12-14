export default {


    methods: {
        change_price_cost_case_unit(i) {
 
                
                if (this.unit_price[i]) {
                        
                    this.total[i] =
                        this.unit_price[i] * this.unit[i][0]* this.qty[i];
                }

          
            
        },

      
      
    },
};
