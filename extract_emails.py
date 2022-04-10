# To my biggest fan, Jace, keep up the great work bucko
# ~Henry Rice

import csv

textFile = open("ref_email_list.txt", 'a')
line_count = 0
emails = 0
duplicates = 0
email_list = []
with open("2022_VT_Referee_List.csv") as csv_file:
    csv_reader = csv.reader(csv_file, delimiter=',')
    for row in csv_reader:
        if line_count == 0:
            print(f'Column names are {", ".join(row)}')
            line_count += 1
        else:
            if row[7] != "":
                # print("Row 7: " + str(row[7]))
                email_list.append(str(row[7]))
            emails += 1
            if row[8] != "":
                if row[7] != row[8]:
                    # print("Row 8: " + str(row[8]))
                    email_list.append(str(row[8]))
                    emails += 1
            line_count += 1

email_set = set(email_list)
duplicates = len(email_list) - len(email_set)

for email in email_set:
    textFile.write(email + ";\n")

textFile.close()
print("Referees: " + str(line_count - 1))
print("Emails Found: " + str(emails))
print("Duplicates Removed: " + str(duplicates))
print("Email List Length: " + str(emails - duplicates))
