$(function() {
    var toggleFunction;
    $('.toggle-handle').click(toggleFunction = function() {
        var area = $('#' + $(this).attr('data-area'));
        if(area.hasClass('expanded')) {
            area.removeClass('expanded');
        } else {
            area.addClass('expanded');
        }
        $(this).blur();
        return false;
    });

    $('#supportedCauses').append(
        $(document.createElement('div')).attr('id', 'pane4').addClass('cause-info').append(
            $(document.createElement('div')).append(
                $(document.createElement('img')).attr('src', 'http://lorempixel.com/420/420/people'),
                $(document.createElement('div')).append(
                    $(document.createElement('h4')).text('[Name]'),
                    $(document.createElement('h4')).text('[Cause]')
                ),
                $(document.createElement('div')).append(
                    $(document.createElement('h4')).text('[X] Votes')
                )
            ),
            $(document.createElement('div')).append(
                $(document.createElement('h4')).text('About:'),
                $(document.createElement('div')).append(
                    $(document.createElement('p')).text(
                        'Nam ex ullum assum apeirian, facilisi splendide quo ex. Sea et nonumy accusata, in utinam vocent facilis vix. \
                        Cu vix eripuit temporibus mediocritatem, denique theophrastus ne mel, et graecis maiorum mediocritatem per. \
                        Magna tacimates sed eu, sit no graeco latine referrentur. Id sed assum quaerendum, apeirian erroribus ut his. Ex mei mazim minimum.'
                    ),
                    $(document.createElement('h5')).html('More at <a>[Website]</a>')
                ),
                $(document.createElement('button')).addClass('btn btn-primary pull-right').text('Give')
            ),
            $(document.createElement('div')).append(
                $(document.createElement('h2')).append(
                    $(document.createElement('a')).append(
                        $(document.createElement('span')).addClass('glyphicon glyphicon-chevron-down')
                    ).attr('href', '#pane4').attr('data-area', 'pane4').click(toggleFunction)
                )
            )
        )
    );
});