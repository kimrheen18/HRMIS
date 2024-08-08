new Vue({
    el: '#projectcode',

    data: {
        projcode: '', errprojcode: false, msgprojcode: '',
        projdesc: '', errprojdesc: false, codes: [],
        projorder: '', errprojorder: false, error: true, code: $('#txtcode').val()
    },

    mounted() {
        if(this.code != ''){
            this.fetchProjectCodeData();
        }else{
            this.fetchData('../libraries/projectcode/fetchCodes');
        }
    },

    watch: {
        'projdesc': function(val){ this.errprojdesc = (val == '') ? true: false; this.checkError();},
        'projorder': function(val){ this.errprojorder = (val == '') ? true: false; this.checkError();},
        'projcode': function(val){
            if(val == ''){
                this.errprojcode = true;
                this.msgprojcode = 'This field is required.';
            }else{
                for(var i = 0; i < this.codes.length; i++) {
                    if(this.codes[i].projectCode.toLowerCase().trim() == val.toLowerCase().trim()) {
                        this.msgprojcode = 'Project Code Code must be unique.'; this.errprojcode = true; break;
                    }else{
                        this.errprojcode = false;
                    }
                }
            }
            this.checkError();
        },
    },

    methods: {
        fetchData: function(url) { axios.get(url).then(function (response) { this.codes = response.data; }.bind(this)); },
        checkError: function() { this.error = ([this.errprojcode, this.errprojdesc, this.errprojorder].includes(true) || [this.projcode, this.projdesc, this.projorder].includes('')) ? true : false; },
        fetchProjectCodeData: function() {
            axios.get('../../libraries/projectcode/fetchProjectCodeData/'+this.code).then(function (response) {
                this.projcode = response.data[0].projectCode;
                this.projdesc = response.data[0].projectDesc;
                this.projorder = response.data[0].projectOrder;
            }.bind(this));
        }
    }
});