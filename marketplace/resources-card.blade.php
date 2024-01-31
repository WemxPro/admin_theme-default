@if($marketplace && count($marketplace))
    <div class="card">
        <div class="card-header">
            <h4>{!! __('admin.marketplace') !!}</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{!! __('admin.name') !!}</th>
                        <th>{!! __('admin.description') !!}</th>
                        <th>{!! __('admin.author') !!}</th>
                        <th>{!! __('admin.version') !!}</th>
                        <th>{!! __('admin.wemx_version') !!} ({{ config('app.version') }})</th>
                        <th>{!! __('admin.price') !!}</th>
                        <th class="text-right">{!! __('admin.actions') !!}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($marketplace['data'] as $resource)
                        @php
                            $installedResource = Module::find($resource['real_name']);
                            $resource['installed'] = (bool)$installedResource;
                            $install_key = $resource['installed'] ? 'reinstall' : 'install';
                            if($resource['installed']) {
                                if(file_exists($installedResource->getExtraPath('Config/config.php'))) {
                                    $config = require $installedResource->getExtraPath('Config/config.php') ?? [];
                                    if (version_compare($config['version'], $resource['version'], '<')){
                                        $install_key = 'update';
                                    }
                                }
                            }
                        @endphp

                        <tr>
                            <td>
                                <img src="{{ $resource['icon'] ?? 'https://imgur.com/koz9j8a.png' }}"
                                     alt="{{ $resource['name'] }}" style="width:32px; height:32px;">
                                {{ $resource['name'] }}
                            </td>
                            <td>{{ Str::limit($resource['short_desc'] ?? $resource['name'], 50) }}</td>
                            <td>
                                <img src="{{ $resource['owner']['avatar'] ?? 'https://imgur.com/koz9j8a.png' }}"
                                     alt="{{ $resource['name'] }}" style="width:32px; height:32px;">
                                {{ $resource['owner']['username'] }}
                            </td>
                            <td>{{ $resource['version'] }}</td>
                            <td>{{ implode(', ', $resource['wemx_version']) }}</td>
                            <td>{{ $resource['is_free'] ? __('admin.free') : $resource['price'] }}</td>
                            <td class="text-right">
                                @if($resource['purchased'])
                                    <a href="{{ route('admin.resource.install', ['resource_id' => $resource['id'], 'version_id' => $resource['version_id']]) }}"
                                       class="btn btn-primary">
                                        {!! __('admin.'.$install_key) !!}
                                    </a>
                                @endif
                                <a href="{{ $resource['view_url'] }}"
                                   class="btn btn-success">{!! __('admin.view') !!}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
