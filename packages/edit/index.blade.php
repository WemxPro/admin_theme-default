@extends(AdminTheme::path('packages/edit/master'), ['title' => 'Package Edit', 'tab' => 'index'])

@section('content')
<div class="">
    <form action="{{ route('packages.update', ['package' => $package->id]) }}" method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="form-group col-md-12 col-12">
                <label for="name">{{ __('admin.package_name') }}</label>
                <input type="text" name="name" id="name"
                       placeholder="{{ __('admin.package_name') }}"
                       class="form-control" value="{{ $package->name }}" required=""/>
            </div>

            <div class="form-group col-md-6 col-6">
                <label for="category">{{ __('admin.category') }}</label>
                <select class="form-control select2 select2-hidden-accessible" name="category" id="category"
                        tabindex="-1" aria-hidden="true">
                    @foreach (Categories::get() as $category)
                        <option value="{{ $category->id }}"
                                @if ($package->category_id == $category->id) selected @endif>{{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6 col-6">
                <label for="status">{{ __('admin.package_status') }}</label>
                <select class="form-control select2 select2-hidden-accessible" name="status" id="status"
                        tabindex="-1" aria-hidden="true">
                    <option value="active" @if ($package->status == 'active') selected @endif>
                        {{ __('admin.active') }}
                    </option>
                    <option value="unlisted"
                            @if ($package->status == 'unlisted') selected @endif>
                        {{ __('admin.unlisted_only_users_with_direct_link_can_view') }}
                    </option>
                    <option value="restricted"
                            @if ($package->status == 'restricted') selected @endif>
                        {{ __('admin.admin_only_only_administrators_can_view') }}
                    </option>
                    <option value="inactive"
                            @if ($package->status == 'inactive') selected @endif>
                        {{ __('admin.retired_inactive_package_will_not_be_shown_to_new') }}
                    </option>
                </select>
            </div>

            <div class="form-group col-md-12 col-12">
                <label>{{ __('admin.service') }}</label>
                <input type="text"
                       value="{{ ucfirst($package->service) }}" class="form-control"
                       disabled=""/>
            </div>

            <div class="form-group col-md-12 col-12 mt-3">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="icon" id="customFile">
                    <label class="custom-file-label"
                           for="customFile">{{ __('admin.choose_file') }}</label>
                </div>
            </div>

            <div class="form-group col-md-12 col-12">
                <label for="description">{{ __('admin.package_description') }}</label>
                <textarea class="summernote form-control" name="description" id="description"
                          style="display: none;">
                @isset($package->description)
                        {!! $package->description !!}
                    @endisset
                </textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6 col-6">
                <label for="global_stock">{{ __('admin.global_stock') }}</label>
                <input type="number" name="global_stock" id="global_stock" min="-1"
                       value="{{ $package->global_quantity }}" class="form-control"
                       required=""/>
                <small class="form-text text-muted">{!! __('admin.client_stock_indicates_the_stock_limit_per_client') !!}</small>
            </div>

            <div class="form-group col-md-6 col-6">
                <label for="stock">{{ __('admin.per_client_stock') }}</label>
                <input type="number" name="client_stock" id="stock" min="-1"
                       value="{{ $package->client_quantity }}" class="form-control"
                       required=""/>
                <small
                    class="form-text text-muted">{!! __('admin.client_stock_indicates_the_stock_limit_per_client') !!}</small>
            </div>

            <div class="form-group col-md-6 col-6">
                <div class="form-group">
                    <div class="control-label">{{ __('admin.require_domain') }}</div>
                    <label class="custom-switch mt-2">
                        <input type="checkbox" name="require_domain" class="custom-switch-input"
                               value="1" @if($package->require_domain) checked @endif>
                        <span class="custom-switch-indicator"></span>
                        <span
                            class="custom-switch-description">{{ __('admin.does_this_package_require_the_user_to_have_domain') }}</span>
                    </label>
                </div>
            </div>

            <div class="form-group col-md-6 col-6">
                <div class="form-group">
                    <div class="control-label">{{ __('admin.allow_notes') }}</div>
                    <label class="custom-switch mt-2">
                        <input type="checkbox" name="allow_notes" class="custom-switch-input"
                               value="1" @if($package->allow_notes) checked @endif>
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">
                            {{ __('admin.allow_users_to_include_special_notes_additional') }}
                        </span>
                    </label>
                </div>
            </div>

            @if($package->service()->canUpgrade())
            <div class="form-group col-md-6 col-6">
                <label for="settings[allow_upgrading]">{{ __('admin.allow_upgrading') }}</label>
                <select class="form-control select2 select2-hidden-accessible" required="" name="settings[allow_upgrading]" id="settings[allow_upgrading]"
                        tabindex="-1" aria-hidden="true">
                    <option value="1" @if($package->settings('allow_upgrading', true)) selected @endif>
                        {!! __('admin.allow_user_upgrade') !!}
                    </option>
                    <option value="0" @if(!$package->settings('allow_upgrading', true)) selected @endif>
                        {!! __('admin.disable_user_upgrade') !!}
                    </option>
                </select>
                <small class="form-text text-muted">{!! __('admin.allow_upgrading_desc') !!}</small>
            </div>
            @endif
        </div>
        <div class="text-right">
            <button class="btn btn-success" type="submit">{{ __('admin.update') }}</button>
        </div>
    </form>
</div>
@endsection
