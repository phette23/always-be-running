//Contains JS for the dynamic tables

function updateTournamentTable(elementID, columns, emptyMessage, csrftoken, data) {
    var nowdate = nowDate();
    $.each(data, function (index, element) {
        newrow = $('<tr>').appendTo(elementID + ' > tbody');

        // if zero rows
        if (data.length == 0) {
            newrow.append($('<td>', {
                text: emptyMessage,
                colspan: columns.length,
                'class': 'text-xs-center'
            }));
            return 0;
        }

        // title
        if ($.inArray('title', columns) > -1) {
            newrow.append($('<td>').append($('<a>', {
                text: element.title,
                href: '/tournaments/' + element.id
            })));
        }
        // date
        if ($.inArray('date', columns) > -1) {
            newrow.append($('<td>', {
                text: element.date
            }));
        }
        // location
        if ($.inArray('location', columns) > -1) {
            newrow.append($('<td>', {
                text: element.location
            }));
        }
        // cardpool
        if ($.inArray('cardpool', columns) > -1) {
            newrow.append($('<td>', {
                text: element.cardpool
            }));
        }
        // type
        if ($.inArray('type', columns) > -1) {
            newrow.append($('<td>').append($('<em>', {
                text: element.type
            })));
        }
        // approved
        if ($.inArray('approval', columns) > -1) {
            cell = $('<td>', {
                'class': 'text-xs-center'
            }).appendTo(newrow);

            if (element.approved === null) {
                cell.append($('<span>', {
                    text: 'pending',
                    'class': 'label label-warning'
                }));
            } else if (element.approved) {
                cell.append($('<span>', {
                    text: 'approved',
                    'class': 'label label-success'
                }));
            } else {
                cell.append($('<i>', {
                    'aria-hidden': true,
                    'class': 'fa fa-thumbs-down text-danger'
                }), ' ', $('<span>', {
                    text: 'rejected',
                    'class': 'label label-danger'
                }));
            }
        }
        // claim
        if ($.inArray('user_claim', columns) > -1) {
            cell = $('<td>', {
                'class': 'text-xs-center'
            }).appendTo(newrow);

            if (element.user_claim) {
                cell.append($('<span>', {
                    text: 'claimed',
                    'class': 'label label-success'
                }));
            } else if (element.concluded) {
                cell.append($('<button>', {
                    'class': 'btn btn-claim btn-xs',
                    'data-toggle': 'modal',
                    'data-target': '#claimModal',
                    'data-tournament-id': element.id,
                    'data-subtitle': element.title + ' - ' + element.date,
                    'data-players-number': element.players_count,
                    'data-top-number': element.top_count
                }).append($('<i>', {
                    'class': 'fa fa-list-ol',
                    'aria-hidden': true
                }), ' claim'));
            } else {
                cell.append($('<span>', {
                    text: 'registered',
                    'class': 'label label-info'
                }));
            }
        }
        // conclusion
        if ($.inArray('conclusion', columns) > -1) {
            cell = $('<td>', {
                'class': 'text-xs-center'
            }).appendTo(newrow);

            if (element.type !== 'non-tournament event') { // if not a non-tournament
                if (element.concluded) {
                    cell.append($('<span>', {
                        text: 'concluded',
                        'class': 'label label-success'
                    }));
                } else if (element.date <= nowdate) {
                    cell.append($('<button>', {
                        'class': 'btn btn-conclude btn-xs',
                        'data-toggle': 'modal',
                        'data-target': '#concludeModal',
                        'data-tournament-id': element.id,
                        'data-subtitle': element.title + ' - ' + element.date
                    }).append($('<i>', {
                        'class': 'fa fa-check',
                        'aria-hidden': true
                    }), ' conclude'));
                } else {
                    cell.append($('<span>', {
                        text: 'not yet',
                        'class': 'label label-info'
                    }));
                }
            } else {
                cell.append($('<span>', {
                    text: '-',
                    'class': ''
                }));
            }
        }
        // players
        if ($.inArray('players', columns) > -1) {
            newrow.append($('<td>', {
                text: element.concluded ? element.players_count : element.registration_count,
                'class': 'text-xs-center'
            }));
        }
        // claims
        if ($.inArray('claims', columns) > -1) {
            cell = $('<td>', {
                'class': 'text-xs-center'
            }).appendTo(newrow);

            if (element.claim_conflict) {
                cell.append($('<i>', {
                    'title': 'conflict',
                    'class': 'fa fa-exclamation-triangle text-danger'
                }), ' ');
            }

            cell.append(element.claim_count);

        }
        // action_edit
        if ($.inArray('action_edit', columns) > -1) {
            newrow.append($('<td>').append($('<a>', {
                'class': 'btn btn-primary btn-xs',
                href: '/tournaments/' + element.id + '/edit'
            }).append($('<i>', {
                'class': 'fa fa-pencil',
                'aria-hidden': true
            }), ' update')));
        }
        // action_approve
        if ($.inArray('action_approve', columns) > -1) {
            newrow.append($('<td>').append($('<a>', {
                'class': 'btn btn-success btn-xs',
                href: '/tournaments/' + element.id + '/approve'
            }).append($('<i>', {
                'class': 'fa fa-thumbs-up',
                'aria-hidden': true
            }), ' approve')));
        }
        // action_reject
        if ($.inArray('action_reject', columns) > -1) {
            newrow.append($('<td>').append($('<a>', {
                'class': 'btn btn-danger btn-xs',
                href: '/tournaments/' + element.id + '/reject'
            }).append($('<i>', {
                'class': 'fa fa-thumbs-down',
                'aria-hidden': true
            }), ' reject')));
        }
        // action_restore
        if ($.inArray('action_restore', columns) > -1) {
            newrow.append($('<td>').append($('<a>', {
                'class': 'btn btn-primary btn-xs',
                href: '/tournaments/' + element.id + '/restore'
            }).append($('<i>', {
                'class': 'fa fa-recycle',
                'aria-hidden': true
            }), ' restore')));
        }
        // action_delete
        if ($.inArray('action_delete', columns) > -1) {
            newrow.append($('<td>').append($('<form>', {
                method: 'POST',
                action: '/tournaments/' + element.id
            }).append($('<input>', {
                name: '_method',
                type: 'hidden',
                value: 'DELETE'
            }), $('<input>', {
                name: '_token',
                type: 'hidden',
                value: csrftoken
            }), $('<button>', {
                type: 'submit',
                'class': 'btn btn-danger btn-xs'
            }).append($('<i>', {
                'class': 'fa fa-trash',
                'aria-hidden': true
            }), ' delete'))));
        }

    }, columns, emptyMessage);
}