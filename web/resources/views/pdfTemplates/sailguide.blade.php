<html>

<head>
    <?php
    $barlowSemiReg = str_replace('\\', '/', public_path('fonts/BarlowSemiCondensed-Regular.ttf'));
    $barlowSemiBold = str_replace('\\', '/', public_path('fonts/BarlowSemiCondensed-Bold.ttf'));
    $barlowCondensedReg = str_replace('\\', '/', public_path('fonts/BarlowCondensed-Regular.ttf'));
    $barlowCondensedBold = str_replace('\\', '/', public_path('fonts/BarlowCondensed-Bold.ttf'));
    ?>
    <style>
        @font-face {
            font-family: 'Barlow Semi Condensed';
            font-style: normal;
            font-weight: 400;
            src: url('{{ $barlowSemiReg }}') format('truetype');
        }

        @font-face {
            font-family: 'Barlow Semi Condensed';
            font-style: normal;
            font-weight: 700;
            src: url('{{ $barlowSemiBold }}') format('truetype');
        }

        @font-face {
            font-family: 'Barlow Condensed';
            font-style: normal;
            font-weight: 400;
            src: url('{{ $barlowCondensedReg }}') format('truetype');
        }

        @font-face {
            font-family: 'Barlow Condensed';
            font-style: normal;
            font-weight: 700;
            src: url('{{ $barlowCondensedBold }}') format('truetype');
        }

        img#img_logo {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
            margin: 0;
            padding: 0;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="flyleaf">
                <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/sail_guide_01.jpg" alt="" style="width: 100% !important;margin: 0 important;margin-top: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            margin-bottom: 0 !important;" id="img_logo">
                <br>
                <!-- <p style="page-break-after: always;"></p> -->
            </div>
            <div class="flyleaf1">
                {!! $data !!}
            </div>
            <div class="flyleaf">
                <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/sail_guide_011.jpg" alt="" style="width: 100% !important;margin: 0 important;margin-top: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            margin-bottom: 0 !important;" id="img_logo">
                <br>
                <!-- <p style="page-break-after: always;"></p> -->
            </div>
        </div>
        <!-- <div class="image">
            <img src="C:/Apache24/htdocs/Elina ISMS\v1/web/public/images/sailguide_theam.png" alt="Elina Logo">
        </div> -->
    </div>
</body>

</html>