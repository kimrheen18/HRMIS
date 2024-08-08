new Vue({
    el: '#payrollgroup',

    data: {
        pgproject: '', errpgproject: false, msgpgcode: '',
        pgcode: '', errpgcode: false, codes: [],
        pgdesc: '', errpgdesc: false, error: true, code: $('#txtcode').val(),
        pgorder: '', errpgorder: false,
        pgrc: '', errpgrc: false  
    },

    mounted() {
        if(this.code != ''){
            this.fetchPayrollGroupData();
        }else{
            this.fetchData('../libraries/payrollgroup/fetchPayrollGroup');
        }
    },

    watch: {
        'pgproject': function(val){ this.errpgproject = (val == '') ? true: false; this.checkError();},
        'pgdesc': function(val){ this.errpgdesc = (val == '') ? true: false; this.checkError();},
        'pgorder': function(val){ this.errpgorder = (val == '') ? true: false; this.checkError();},
        'pgrc': function(val){ this.errpgrc = (val == '') ? true: false; this.checkError();},
        'pgcode': function(val){
            if(val == ''){
                this.errpgcode = true;
                this.msgpgcode = 'This field is required.';
            }else{
                for(var i = 0; i < this.codes.length; i++) {
                    if(this.codes[i].payrollGroupCode.toLowerCase().trim() == val.toLowerCase().trim()) {
                        this.msgpgcode = 'Project Code Code must be unique.'; this.errpgcode = true; break;
                    }else{
                        this.errpgcode = false;
                    }
                }
            }
            this.checkError();
        },
    },

    methods: {
        fetchData: function(url) { axios.get(url).then(function (response) { this.codes = response.data; }.bind(this)); },
        checkError: function() { this.error = ([this.errpgproject,this.errpgcode,this.errpgdesc,this.errpgorder,this.errpgrc].includes(true) || [this.pgproject,this.pgcode,this.pgdesc,this.pgorder,this.pgrc].includes('')) ? true : false; },
        fetchPayrollGroupData: function() {
            axios.get('../../libraries/payrollgroup/fetchPayrollGroupData/'+this.code).then(function (response) {
                this.pgproject = response.data[0].projectCode;
                this.pgcode = response.data[0].payrollGroupCode;
                this.pgdesc = response.data[0].payrollGroupName;
                this.pgorder = response.data[0].payrollGroupOrder;
                this.pgrc = response.data[0].payrollGroupRC;
            }.bind(this));
        }
    }
});