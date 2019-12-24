{{ html()->form('get', route('aio-exam::admin.question.index'))->class('form-inline mt-2')->open() }}
    {{-- {{ html()->select('category', $question_categories, isset($search['category']) ? $search['category'] : null)->class('form-control mb-2 mr-sm-2')->placeholder('分类') }} --}}
    {{ html()->select('type', $question_types, $search['type'] ?? null)
        ->placeholder('题目类型')
        ->class('form-control mb-2 mr-sm-2') }}
    {{ html()->text('term', $search['term'] ?? null)
        ->placeholder('题目ID/题干')
        ->class('form-control mb-2 mr-sm-2') }}
    {{ html()->submit('搜索')->class('btn btn-primary mb-2') }}
{{ html()->form()->close() }}
