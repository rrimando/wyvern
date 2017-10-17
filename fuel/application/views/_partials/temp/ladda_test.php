<button id="lada-test" class="btn btn-primary ladda-button" data-style="slide-up"><span class="ladda-label">Ladda Test</span></button>
<script type="text/javascript">
    $(document).ready(function () {
        $('#lada-test').click(function (e) {
            e.preventDefault();
            var l = Ladda.create(this);
            l.start();
            return false;
        });
    })
</script>
