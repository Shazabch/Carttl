<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Inspection Report #{{ $reportInView->id }}</title>

</head>

<body>
    <div class="">
        <div class="report-card">

            <div class="card-body">
                <livewire:admin.inspection.car-damage-view :inspectionId="$reportInView->id" />
            </div>
        </div>
    </div>
</body>

</html>