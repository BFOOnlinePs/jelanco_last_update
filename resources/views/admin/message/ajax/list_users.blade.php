        <div style="width:100%">
            <table style="width:100%" class="table table-hover">
                <tbody>
                @if($users->isEmpty())
                    <tr>
                        <td colspan="">لا توجد نتائج للبحث</td>
                    </tr>
                @else
                    @foreach($users as $key)
                    <tr>
                        <td style="cursor: pointer" onclick="click_button_to_show_message_and_order({{ $key->id }})"><span style="font-size: 12px">{{ $key->name }}</span></td>
                    </tr>
                  @endforeach
                @endif
                </tbody>
            </table>
        </div>
