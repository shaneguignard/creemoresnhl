p = readtable("allPlayers.txt");
p = sortrows(p, 'name');

sp = readtable("allPlayers_sorted.txt", 'Format', '%s%s%n%n%n%n');

t = table();
t.name = unique(sp.name);
[t.first,t.last] = strtok(t.name); %splits name string into first name and last name


i = 1



% 
% while (i < length(t.name))
%     goals = [0, 0, 0, 0, 0];
%     assists = [0, 0, 0, 0, 0];
%     pts = [0, 0, 0, 0, 0];
%     pim = [0, 0, 0, 0, 0];
%     years = 1
%     j = 1;
%     n = 1;
%     while (j < length(p.name))
%         if (isequal(t.name(i), p.name(j)))
%             p.name(j)
%             
%             goals(n) = p.g(j);
%             assists(n) = p.a(j);
%             pts(n) = p.pts(j);
%             pim(n) = p.pim(j);
%             years = years + 1;
%             j = j + 1;
%             n = n + 1;
%         else 
%             j = j + 1;
%             n = n + 1;
%         end
%         
%     end
%     t.g(i) = sum(goals);
%     t.a(i) = sum(assists);
%     t.pts(i) = sum(pts);
%     t.pim(i) = sum(pim); 
%     t.years(i) = years;
%     i = i + 1;
% end