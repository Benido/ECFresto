insert into admin(id, email, password, roles)
values (0x1edeea5d332c6bb4a0283bc3c1338ace, 'admin@admin.fr', '$2y$13$lBuGxki.2X/SBZlQC6ExheviZjOYGgxzhmlNfbSWqqET9NVPSMhpW', 'ROLE_ADMIN ');

insert into client(id, email, password, roles, default_seats_number)
values (0x1edeea5d373b66a6b83c3bc3c1338ace, 'client@client.fr', '$2y$13$qQxvOr1O6yePXbN2bBk9/.UVcte4xcK.cHcZU0LaBHxxDEkBNrdDG', 'ROLE_CLIENT', 4);

insert into restaurant(max_capacity)
values (30);

insert into business_hours (weekday, opening_hour, closing_hour)
values ('lundi', null, null);
insert into business_hours (weekday, opening_hour, closing_hour)
values ('mardi', '10:00', '15:00');
insert into business_hours (weekday, opening_hour, closing_hour)
values ('mardi', '17:00', '22:30');
insert into business_hours (weekday, opening_hour, closing_hour)
values ('mercredi', '10:30', '15:30');
insert into business_hours (weekday, opening_hour, closing_hour)
values ('mercredi', '17:00', '22:30');
insert into business_hours (weekday, opening_hour, closing_hour)
values ('jeudi', '10:00', '15:00');
insert into business_hours (weekday, opening_hour, closing_hour)
values ('jeudi', '17:00', '23:00');
insert into business_hours (weekday, opening_hour, closing_hour)
values ('vendredi', '10:00', '23:00');
insert into business_hours (weekday, opening_hour, closing_hour)
values ('samedi', '9:00', '1:00');
insert into business_hours (weekday, opening_hour, closing_hour)
values ('dimanche', '9:00', '16:00');