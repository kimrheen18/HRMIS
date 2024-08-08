new Vue({
    el: '#income',

    data: {
        incomecode: '', errincomecode: false, msgincomecode: 'This field is required.',
        incomedesc: '', errincomedesc: false, codes: [],
        incometype: '', errincometype: false, error: true, code: $('#txtcode').val()
    },

    mounted() {
        if(this.code != ''){
            this.fetchIncomeData();
        }else{
            this.fetchData('../libraries/income/fetchIncome');
        }
    },

    watch: {
        'incomedesc': function(val){ this.errincomedesc = (val == '') ? true: false; this.checkError();},
        'incometype': function(val){ this.errincometype = (val == '') ? true: false; this.checkError();},
        'incomecode': function(val){
            if(val == ''){
                this.errincomecode = true;
            }else{
                for(var i = 0; i < this.codes.length; i++) {
                    if(this.codes[i].incomeCode.toLowerCase().trim() == val.toLowerCase().trim()) {
                        this.msgincomecode = 'Income Code must be unique.'; this.errincomecode = true; break;
                    }else{
                        this.errincomecode = false;
                    }
                }
            }
            this.checkError();
        },
    },

    methods: {
        fetchData: function(url) { axios.get(url).then(function (response) { this.codes = response.data; }.bind(this)); },
        checkError: function() { this.error = ([this.errincomecode, this.errincomedesc, this.errincometype].includes(true) || [this.incomecode, this.incomedesc, this.incometype].includes('')) ? true : false; },
        fetchIncomeData: function() {
            axios.get('../../libraries/income/fetchIncomeData/'+this.code).then(function (response) {
                this.incomecode = response.data[0].incomeCode;
                this.incomedesc = response.data[0].incomeDesc;
                this.incometype = response.data[0].incomeType;
            }.bind(this));
        }
    }
});