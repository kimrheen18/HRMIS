new Vue({
    el: '#tab-deduction',

    data: {
        codes: [], code: $('#txtcode').val(),
        agency : '', erragency: false,
        deductcode : '', errdeductcode: false, msgdeductcode: 'This field is required.',
        desc : '', errdesc: false,
        acctcode : '', erracctcode: false,
        type : '', errtype: false,
        error: true
    },

    mounted() {
        if(this.code != ''){
            this.fetchData('../../libraries/Deductions/fetchDeductionCodes');
            this.fetchDeductionData();
        }else{
            this.fetchData('../libraries/Deductions/fetchDeductionCodes');
        }
    },

    watch: {
        'agency': function(val){ this.erragency = (val == '') ? true: false; this.checkError();},
        'desc': function(val){ this.errdesc = (val == '') ? true: false; this.checkError();},
        'acctcode': function(val){ this.erracctcode = (val == '') ? true: false; this.checkError();},
        'type': function(val){ this.errtype = (val == '') ? true: false; this.checkError();},
        'deductcode': function(val){
            if(val == ''){
                this.errdeductcode = true;
            }else{
                if(this.code == ''){
                    for(var i = 0; i < this.codes.length; i++) {
                        if(this.codes[i].deductionCode.toLowerCase().trim() == val.toLowerCase().trim()) {
                            this.msgdeductcode = 'Deduction Code must be unique.'; this.errdeductcode = true; break;
                        }else{
                            this.errdeductcode = false;
                        }
                    }
                } else { this.errdeductcode = false; }
            }
            this.checkError();
        },
    },

    methods: {
        fetchData: function(url) { axios.get(url).then(function (response) { this.codes = response.data; }.bind(this)); },
        checkError: function() { this.error = ([this.erragency, this.errdeductcode, this.errdesc, this.erracctcode, this.errtype].includes(true) || [this.agency, this.deductcode, this.desc, this.acctcode, this.type].includes('')) ? true : false; },
        fetchDeductionData: function() {
            axios.get('../../libraries/Deductions/fetchDeduction/'+this.code).then(function (response) {
                this.agency = response.data.deductionGroupCode;
                this.deductcode = response.data.deductionCode;
                this.desc = response.data.deductionDesc;
                this.acctcode = response.data.deductionGroupCode;
                this.type = response.data.deductionType;
            }.bind(this));
        },
    }
});