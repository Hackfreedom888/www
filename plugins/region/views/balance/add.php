<?php defined('YII_ENV') or exit('Access Denied'); ?>
<?php Yii::$app->loadViewComponent('app-rich-text') ?>
<style>
    .form-body {
        padding: 20px 0;
        background-color: #fff;
        margin-bottom: 20px;
        padding-right: 50%;
    }

    .form-button {
        margin: 0!important;
    }

    .form-button .el-form-item__content {
        margin-left: 0!important;
    }

    .show {
        margin-left: 30px;
        color: #409EFF;
        height: 50px;
        line-height: 50px;
        cursor: pointer;
    }

    .select {
        position: relative;
        margin-left: 10px;
    }

    .select:first-of-type {
        margin-left: 0;
    }

    .select .select-info {
        padding-left: 30px;
    }

    .select .date-icon {
        position: absolute;
        height: 100%;
        width: 25px;
        left: 5px;
        top: 0;
        color: #C0C4CC;
    }

    .select .date-icon i {
        line-height: 36px;
        height: 100%;
        width: 28px;
        text-align: center;
    }
    .el-select .el-input .el-select__caret {
        display: none;
    }

    .show-info {
        border-radius: 6px;
        border: 1px solid #e2e2e2;
        padding: 10px 25px;
        width: 375px;
        margin-left: 20px;
        margin-top: 10px;
    }

    .show-info div {
        height: 32px;
        line-height: 32px;
    }

    .el-dialog__body {
        padding: 10px 30px 10px 20px;
        font-size: 15px;
    }

    .button-item {
        padding: 9px 25px;
        margin-bottom: 25px;
    }
    .date .el-form-item__label:before {
        content: '*';
        color: #F56C6C;
        margin-right: 4px;
    }
    .el-form-item {
        margin-bottom: 6px;
    }

    .dialog-form-head {
        width: 100%;
        background-color: #F5F7FA;
        color: #8F8F92;
        text-align: center;
        height: 45px;
        line-height: 45px;
        font-weight: 600;
        margin-top: 5px;
    }
</style>
<section id="app" v-cloak>
    <el-card class="box-card" v-loading="loading" shadow="never" style="border:0" body-style="background-color: #f3f3f3;padding: 10px 0 0;">
        <div slot="header" class="clearfix">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item><span style="color: #409EFF;cursor: pointer"
                                          @click="$navigate({r:'plugin/region/mall/balance/index'})">????????????</span></el-breadcrumb-item>
                <el-breadcrumb-item>????????????</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div class="form-body">
            <div class="show" @click="dialogVisible = true">??????????????????????????????????????????</div>
            <el-form :model="form" label-width="100px" :rules="FormRules" ref="form">
                <el-form-item label="????????????" prop="title">
                    <el-form-item label="????????????" prop="type">
                        <el-radio-group @change="toggle" v-model="type">
                            <el-radio label="1">??????</el-radio>
                            <el-radio label="2">??????</el-radio>
                        </el-radio-group>
                    </el-form-item>
                    <el-form-item label="????????????" prop="date" class="date">
                        <div v-if="detail.is_bonus == 1" flex="dir:left cross:center">
                            <div class="select">
                                <div class="select-info">{{detail.year}}</div>
                                <div class="date-icon">
                                    <i class="el-input__icon el-icon-date"></i>
                                </div>
                            </div>
                            <div class="select">
                                <div class="select-info">{{detail.mouth}}</div>
                                <div class="date-icon">
                                    <i class="el-input__icon el-icon-date"></i>
                                </div>
                            </div>
                            <div v-if="type == 1" class="select">
                                <div class="select-info">{{detail.week}}</div>
                                <div class="date-icon">
                                    <i class="el-input__icon el-icon-date"></i>
                                </div>
                            </div>
                        </div>
                        <div v-else-if="detail.is_bonus == 0 && !loading" style="color: #ff4544;">{{type == 1 ? '?????????????????????' : '?????????????????????'}}</div>
                    </el-form-item>
                </el-form-item>
                <el-form-item label="????????????" prop="title">
                    <div class="show-info">
                        <div>?????????: <span v-if="detail.is_bonus == 1">{{detail.first_day}}~{{detail.last_day}}</span></div>
                        <div>????????????: <span v-if="detail.is_bonus == 1">{{detail.order_num}}</span></div>
                        <div>???????????????: <span v-if="detail.is_bonus == 1">???{{detail.total_pay_price}}</span></div>
                        <div>???????????????: <span v-if="detail.is_bonus == 1">???{{detail.bonus_price}}(????????????{{detail.region_rate}}%)</span></div>
                        <div>????????????: <span v-if="detail.is_bonus == 1">{{detail.region_num}}</span></div>
                    </div>
                </el-form-item>
            </el-form>
        </div>
        <el-button type="primary" v-if="detail.is_bonus == 1" @click="loadData(1)" :loading="submitLoading" class="button-item">??????</el-button>
    </el-card>
    <el-dialog title="????????????????????????" :visible.sync="dialogVisible">
        <div>
            <div>??????: ?????????????????????????????????????????????????????????????????????????????????????????????</div>
            <div>??????????????????????????????????????????1000???????????????????????????10%????????????????????????100??????</div>
            <div>??????????????????????????????????????????2000???????????????????????????10%????????????????????????200??????</div>
            <div>????????????????????????????????????????????????????????????:(??????????????????????????????????????????????????????/??????????????????)</div>
        </div>
        <div flex="main:justify">
            <div style="width: 48%;margin-bottom: 5px">
                <div class="dialog-form-head">?????????</div>
                <el-table :data="tableData1" border>
                    <el-table-column prop="level" label="????????????"></el-table-column>
                    <el-table-column prop="rate" label="??????????????????"></el-table-column>
                    <el-table-column prop="number" label="????????????"></el-table-column>
                </el-table>
            </div>
            <div style="width: 48%;margin-bottom: 5px">
                <div class="dialog-form-head">?????????</div>
                <el-table :data="tableData2" border>
                    <el-table-column prop="level" label="????????????"></el-table-column>
                    <el-table-column prop="rate" label="??????????????????"></el-table-column>
                    <el-table-column prop="number" label="????????????"></el-table-column>
                </el-table>
            </div>
        </div>
        <div>
            <div>???????????????????????????????????????</div>
            <div>????????????40%*15+30%*10+20%*5=10???</div>
            <div>????????????50%*20+40%*14+30%*8=18???</div>
        </div>
        <div flex="main:justify">
            <div style="width: 48%;margin-bottom: 5px">
                <div class="dialog-form-head">?????????</div>
                <el-table :data="tableData1" border>
                    <el-table-column prop="level" label="????????????"></el-table-column>
                    <el-table-column width="110" prop="rate" label="??????????????????"></el-table-column>
                    <el-table-column prop="number" label="????????????"></el-table-column>
                    <el-table-column width="150" prop="about" label="?????????????????????">
                        <template slot-scope="scope">
                            <div style="color: #FF9C54">{{scope.row.rate}}*100/10={{scope.row.about}}</div>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
            <div style="width: 48%;margin-bottom: 5px">
                <div class="dialog-form-head">?????????</div>
                <el-table :data="tableData2" border>
                    <el-table-column prop="level" label="????????????"></el-table-column>
                    <el-table-column width="110" prop="rate" label="??????????????????"></el-table-column>
                    <el-table-column prop="number" label="????????????"></el-table-column>
                    <el-table-column width="150" prop="about" label="?????????????????????">
                        <template slot-scope="scope">
                            <div style="color: #FF9C54">{{scope.row.rate}}*200/18={{scope.row.about}}</div>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </div>
        <div>
            <div>???????????????????????????????????????</div>
            <div>????????????4*15+3*10+2*5=100???</div>
            <div>????????????5.55*20+4.44*14+3.33*8???200???</div>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button size="small" type="primary" size="small" @click="dialogVisible = false">????????????</el-button>
        </span>
    </el-dialog>
</section>
<script>
    const app = new Vue({
        el: '#app',
        data() {
            let validatePass = (rule, value, callback) => {
                if (!this.year) {
                    callback('???????????????');
                } else if (!this.month) {
                    callback('???????????????');
                } else if (!this.week && this.type == 1) {
                    callback('??????????????????');
                } else {
                    callback();
                }
            };
            return {
                tableData1: [
                    {level:'?????????',rate: '40%', number: 15, about:4},
                    {level:'?????????',rate: '30%', number: 10, about:3},
                    {level:'???/?????????',rate: '20%', number: 5, about:2},
                ],
                tableData2: [
                    {level:'?????????',rate: '50%', number: 20, about:5.55},
                    {level:'?????????',rate: '40%', number: 14, about:4.44},
                    {level:'???/?????????',rate: '30%', number: 8, about:3.33},
                ],
                dialogVisible: false,
                loading: false,
                form: {
                    title: ''
                },
                detail: {},
                type: '1',
                year: '',
                month: '',
                week: '',
                time: '',
                choose: '',
                order_num: '',
                order_total_price: '',
                share_price: '',
                region_num: '',
                submitLoading: false,
                FormRules: {
                    type: [
                        { required: true, message: '?????????????????????', trigger: 'blur' }
                    ],
                    // date: [
                    //     { validator: validatePass, trigger: 'change' }
                    // ],
                }
            };
        },
        methods: {
            chooseYear(e) {
                this.choose = e;
            },
            toggle(e) {
                this.loadData();
            },
            // ????????????
            loadData(is_save) {
                if(is_save) {
                    this.submitLoading = true;
                }else {
                    this.loading = true;
                }
                request({
                    params: {
                        r: 'plugin/region/mall/bonus/bonus-data',
                        type: this.type,
                        is_save: is_save ? is_save : 0
                    },
                    method: 'get',
                }).then(e => {
                    if(is_save) {
                        this.get(e.data.queue_id)
                    }else {
                        this.loading = false;
                        if (e.data.code == 0) {
                            this.detail = e.data.data;
                        } else {
                            this.$message.error(e.data.msg);
                        }
                    }
                }).catch(e => {
                    this.loading = false;
                });
            },
            get(queue_id) {
                request({
                    params: {
                        r: 'plugin/region/mall/bonus/bonus-status',
                        queue_id: queue_id
                    },
                    method: 'get',
                }).then(e => {
                    if (e.data.code == 0) {
                        if(e.data.data.retry == 1) {
                            this.get(queue_id);
                        }else {
                            this.submitLoading = false;
                            this.$message.success(e.data.msg);
                            this.loadData();
                        }
                    } else {
                        this.$message.error(e.data.msg);
                    }
                }).catch(e => {
                    this.submitLoading = false;
                });
            },

        },

        created() {
            this.loadData();
        }
    })
</script>
