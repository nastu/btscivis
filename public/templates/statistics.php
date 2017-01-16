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
            <div class="box-body">
                {BSC116RUN}
                [BSC116RUN]
                {BSC126RUN}
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
                {BSC116IDLE}
                [BSC116IDLE]
                {BSC126IDLE}
                [BSC126IDLE]
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
                {BSC116OFFLINE}
                [BSC116OFFLINE]
                {BSC126OFFLINE}
                [BSC126OFFLINE]
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