<script src="{{ asset('assets/js/utils.js') }}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/httpAgent.js') }}?v={{ time() }}"></script>
{{--<link rel="stylesheet" href="{{ asset('assets/libs/tom-select-2.2.2/package/dist/css/tom-select.min.css') }}">--}}
{{--<script src="{{ asset('assets/libs/tom-select-2.2.2/package/dist/js/tom-select.complete.min.js') }}"></script>--}}

{{--<script !src="">--}}
{{--    function makeSpecListWithTomSelect() {--}}
{{--        let config = {--}}
{{--            plugins: {--}}
{{--                remove_button:{--}}
{{--                    title:'حذف',--}}
{{--                }--}}
{{--            },--}}
{{--            valueField: 'id',--}}
{{--            labelField: 'label',--}}
{{--            searchField: ['label','type'],--}}
{{--            // fetch remote data--}}
{{--            load: function(query, callback) {--}}

{{--                var url = '{{ route("Api > Query > Specs") }}?q=' + encodeURIComponent(query);--}}
{{--                fetch(url)--}}
{{--                    .then(response => response.json())--}}
{{--                    .then(json => {--}}
{{--                        callback(json.result.list);--}}
{{--                        self.settings.load = null;--}}
{{--                    }).catch(()=>{--}}
{{--                        callback();--}}
{{--                    });--}}

{{--            },--}}
{{--            // custom rendering function for options--}}
{{--            render: {--}}
{{--                option: function(item, escape) {--}}
{{--                    return `<div class="py-2 d-flex">--}}
{{--    							<div class="mb-1">--}}
{{--    								<span class="h5">--}}
{{--    									${ escape(item.label) }--}}
{{--    								</span>--}}
{{--    							</div>--}}
{{--    					 		<div class="ms-auto">${ escape(item.type.join(', ')) }</div>--}}
{{--    						</div>`;--}}
{{--                }--}}
{{--            },--}}
{{--        };--}}
{{--        new TomSelect('#user-interests', config);--}}

{{--    }--}}
{{--    makeSpecListWithTomSelect();--}}

{{--</script>--}}
