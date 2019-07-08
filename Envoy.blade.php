@servers(['localhost' => 'rodrigomassiolo@parkisoft'])

@setup
    $user = 'rodrigomassiolo';
    $domain = 'parkinsoft';
@endsetup


@task('pepe', ['on' => 'localhost'])
    ls -l
@endtask
