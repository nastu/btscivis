<?php ?>
<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Running configurations</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>

                <!-- /.box-tools -->
            </div>
            <div class="box-body text-center">
                <h3>{BSC116RUN}</h3>
                [BSC116RUN]
                <h3>{BSC126RUN}</h3>
                [BSC126RUN]
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Idle configurations</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>

                <!-- /.box-tools -->
            </div>
            <div class="box-body">
                <div class="col-lg-12">
                    <div class="box-group text-center">
                        <h3>{BSC116IDLE}</h3>
                        [BSC116IDLE]
                    </div>
                    <div class="box-group text-center">
                        <h3>{BSC126IDLE}</h3>
                        [BSC126IDLE]
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Offline configurations</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>

                <!-- /.box-tools -->
            </div>
            <div class="box-body">
                <div class="col-lg-12">
                    <div class="box-group text-center">
                        <h3>{BSC116OFFLINE}</h3>
                        [BSC116OFFLINE]
                    </div>
                    <div class="box-group text-center">
                        <h3>{BSC126OFFLINE}</h3>
                        [BSC126OFFLINE]
                    </div>
                </div>
            </div>
        </div>
        <!-- /.info-box -->
    </div>
</div>
<script>
    setTimeout(function () {
        window.location.reload(1);
    }, 60000);
</script>