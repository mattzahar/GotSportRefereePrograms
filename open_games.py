import csv

IN_FILENAME = "assignor_matches.csv"
REF_FILE = "referees_master.csv"
OUT_FILE = "open_games.txt"
ADVISOR_FILE = "advisor_matches.txt"
UNFILLED = "unfilled_matches.txt"

open_games = []

referee_list = []

small_without_ref = []
without_crew = []
without_ref = []
without_ars = []

SAT_DATE = "10/09/2021"
SUN_DATE = "10/10/2021"

TOURNAMENT = False
IS_ESSEX = False

def main():
    loadReferees()

    total_games, small_refs, full_refs, ars = getOpenGames(SAT_DATE)
    outputGames(SAT_DATE, total_games, small_refs, full_refs, ars)

    open_games.clear()
    small_without_ref.clear()
    without_crew.clear()
    without_ref.clear()
    without_ars.clear()

    total_games, small_refs, full_refs, ars = getOpenGames(SUN_DATE)
    outputGames(SUN_DATE, total_games, small_refs, full_refs, ars)

def getOpenGames(date):
    line_count = 0
    small_refs = 0
    full_refs = 0
    total_games = 0
    ars = 0

    if date == SAT_DATE:
        writeFile = open(ADVISOR_FILE, "w")
    else:
        writeFile = open(ADVISOR_FILE, "a")
    writeFile.write("ADVISOR MATCHES FOR " + date)
    writeFile.write("\n")
    writeFile.write("\n")
    with open(IN_FILENAME, 'r') as csv_file:
        csv_reader = csv.reader(csv_file, delimiter=',')
        for row in csv_reader:
            if line_count == 0:
                #print(f'Column names are {", ".join(row)}')
                line_count += 1
            else:
                if row[3] == date:
                    total_games += 1
                if "U8" in row[2] or "U10" in row[2] or ("2009" in row[2] or "U12" in row[2] and not IS_ESSEX) \
                        or "2011" in row[2]:
                    age = ""
                    location = ""
                    if "U8" in row[2]:
                        if "Boys" in row[2]:
                            age = "U8B"
                        elif "Girls" in row[2]:
                            age = "U8G"
                        elif "Coed" in row[2]:
                            age = "U8C"
                    elif "U10" in row[2] or "2011" in row[2]:
                        if "Boys" in row[2]:
                            age = "U10B"
                        elif "Girls" in row[2]:
                            age = "U10G"
                    elif "U12" in row[2] or "2009" in row[2]:
                        if "Boys" in row[2]:
                            age = "U12B"
                        elif "Girls" in row[2]:
                            age = "U12G"
                    if ":" in row[5]:
                        location = row[5].split(":")
                    else:
                        if row[5] == "":
                            location = "TBD"
                        else:
                            location = row[5]
                    print(location)
                    if location == "TBD":
                        game = Game(row[1], age, location, row[4], row[3], "REF")
                    else:
                        game = Game(row[1], age, location[0].strip(), row[4], row[3], "REF")

                    # Game has REF
                    if row[8] != "":
                        if "U10" in row[2] or "U12" in row[2]:
                            if row[3] == date:
                                for ref in referee_list:
                                    name = ref.first_name + " " + ref.last_name
                                    if (row[8].lower() == name.lower()) and (int(ref.yrs_expr) <= 2):
                                        writeFile.write("@" + game.location + " - " + game.time + " - " + game.age +
                                                        " - " + "#" + str(game.num))
                                        writeFile.write("\n")
                                        writeFile.write("REF: " + name + " AGE: " + ref.age + " SEX: " + ref.gender + " YRS EXPR: " + ref.yrs_expr)
                                        writeFile.write("\n")
                                        if ref.email_snd != "":
                                            writeFile.write("Email(s): " + ref.email + "; " + ref.email_snd + ";")
                                        else:
                                            writeFile.write("Email(s): " + ref.email + ";")
                                        writeFile.write("\n")
                                        writeFile.write("\n")
                    # Game is OPEN
                    else:
                        if row[3] == date:
                            open_games.append(game)
                            small_refs += 1
                            if "U8" not in age:
                                small_without_ref.append(game)
                else:
                    # Game is OPEN
                    if not TOURNAMENT:
                        if row[8] == "" or row[10] == "" or row[11] == "":
                            age = ""
                            positions = ""
                            location = ""
                            if "U14" in row[2] or "2007" in row[2]:
                                if "Boys" in row[2]:
                                    age = "U14B"
                                elif "Girls" in row[2]:
                                    age = "U14G"
                            elif "U15" in row[2] or "2006" in row[2]:
                                if "Boys" in row[2]:
                                    age = "U15B"
                                elif "Girls" in row[2]:
                                    age = "U15G"
                            elif "U16" in row[2] or "2005" in row[2]:
                                if "Boys" in row[2]:
                                    age = "U16B"
                                elif "Girls" in row[2]:
                                    age = "U16G"
                            elif "U17" in row[2] or "2004" in row[2]:
                                if "Boys" in row[2]:
                                    age = "U17B"
                                elif "Girls" in row[2]:
                                    age = "U17G"
                            elif "High School" in row[2] or "U19" in row[2] or "2002" in row[2]:
                                if "Boys" in row[2]:
                                    age = "U19B"
                                elif "Girls" in row[2]:
                                    age = "U19G"
                            # Find Positions
                            if row[8] == "":
                                positions = "REF"
                                if row[3] == date:
                                    full_refs += 1
                            if row[10] == "":
                                if row[3] == date:
                                    ars += 1
                                if positions != "":
                                    positions += ",AR1"
                                else:
                                    positions += "AR1"
                            if row[11] == "":
                                if row[3] == date:
                                    ars += 1
                                if positions != "":
                                    positions += ",AR2"
                                else:
                                    positions += "AR2"
                            if ":" in row[5]:
                                location = row[5].split(":")
                            else:
                                if row[5] == "":
                                    location = "TBD"
                                else:
                                    location = row[5]
                            if location == "TBD":
                                game = Game(row[1], age, location, row[4], row[3], positions)
                            else:
                                game = Game(row[1], age, location[0].strip(), row[4], row[3], positions)
                            open_games.append(game)
                            if row[3] == date:
                                if "REF,AR1,AR2" in positions:
                                    without_crew.append(game)
                                elif "REF" in positions:
                                    without_ref.append(game)
                                elif "AR1,AR2" in positions:
                                    without_ars.append(game)
                    else:
                        if row[8] == "" or row[9] == "" or row[10] == "":
                            age = ""
                            positions = ""
                            location = ""
                            if IS_ESSEX:
                                if "U12" in row[2] or "2009" in row[2]:
                                    if "Boys" in row[2]:
                                        age = "U12B"
                                    elif "Girls" in row[2]:
                                        age = "U12G"
                            if "U14" in row[2] or "2007" in row[2]:
                                if "Boys" in row[2]:
                                    age = "U14B"
                                elif "Girls" in row[2]:
                                    age = "U14G"
                            elif "U15" in row[2] or "2006" in row[2]:
                                if "Boys" in row[2]:
                                    age = "U15B"
                                elif "Girls" in row[2]:
                                    age = "U15G"
                            elif "U16" in row[2] or "2005" in row[2]:
                                if "Boys" in row[2]:
                                    age = "U16B"
                                elif "Girls" in row[2]:
                                    age = "U16G"
                            elif "U17" in row[2] or "2004" in row[2]:
                                if "Boys" in row[2]:
                                    age = "U17B"
                                elif "Girls" in row[2]:
                                    age = "U17G"
                            elif "High School" in row[2] or "U19" in row[2] or "HS" in row[2] or "2002" in row[2]:
                                if "Boys" in row[2]:
                                    age = "U19B"
                                elif "Girls" in row[2]:
                                    age = "U19G"
                            # Find Positions
                            if row[8] == "":
                                positions = "REF"
                                if row[3] == date:
                                    full_refs += 1
                            if row[9] == "":
                                if row[3] == date:
                                    ars += 1
                                if positions != "":
                                    positions += ",AR1"
                                else:
                                    positions += "AR1"
                            if row[10] == "":
                                if row[3] == date:
                                    ars += 1
                                if positions != "":
                                    positions += ",AR2"
                                else:
                                    positions += "AR2"
                            # if ":" in row[5]:
                            #     location = row[5].split(":")
                            # else:
                            location = row[5]
                            game = Game(row[1], age, location, row[4], row[3], positions)
                            open_games.append(game)
                            if row[3] == date:
                                if "REF,AR1,AR2" in positions:
                                    without_crew.append(game)
                                elif "REF" in positions:
                                    without_ref.append(game)
                                elif "AR1,AR2" in positions:
                                    without_ars.append(game)
            line_count += 1
    writeFile.close()
    csv_file.close()
    return total_games, small_refs, full_refs, ars

def outputGames(date, total_games, small_refs, full_refs, ars):
    writeFile = open(OUT_FILE, 'w')
    if date == SAT_DATE:
        writeFile = open(UNFILLED, "w")
    else:
        writeFile = open(UNFILLED, "a")

    writeFile.write("\n")
    print("OPEN GAMES " + date)
    writeFile.write("OPEN GAMES " + date + "\n")
    writeFile.write("\n")
    number_of_games = 0
    for game in open_games:
        if game.date == date:
            number_of_games += 1
            print("@" + game.location + " - " + game.time + " - " + game.age + " - " + "#" + str(game.num) + " - " + game.position)
            print("")
    print("TOTAL GAMES: " + str(total_games))
    print("# OF GAMES WITHOUT FULL CREW: " + str(number_of_games))
    print("OPEN U8-U12 REFS: " + str(small_refs))
    print("OPEN U14+ REFS: " + str(full_refs))
    print("OPEN U14+ ARs: " + str(ars))
    print("")
    writeFile.write("TOTAL GAMES: " + str(total_games) + "\n")
    writeFile.write("# OF GAMES WITHOUT FULL CREW: " + str(number_of_games) + "\n")
    writeFile.write("OPEN U10-U12 REFS: " + str(small_refs) + "\n")
    writeFile.write("OPEN U14+ REFS: " + str(full_refs) + "\n")
    writeFile.write("OPEN U14+ ARs: " + str(ars) + "\n")
    writeFile.write("\n")

    if number_of_games != 0:
        writeFile.write("============== U14+ GAMES MISSING WHOLE CREW: ==============\n")
    for game in without_crew:
        writeFile.write("@" + game.location + " - " + game.time + " - " + game.age + " - " + "#" + str(game.num) + "\n")
    if len(without_ref) != 0:
        writeFile.write("\n")
        writeFile.write("============== U14+ GAMES WITH NO REFEREE: ==============\n")
        writeFile.write("== ARs to be contacted and removed if no one wants to be there Referee. ==\n")
    for game in without_ref:
        writeFile.write("@" + game.location + " - " + game.time + " - " + game.age + " - " + "#" + str(game.num) + "\n")
    if len(without_ars) != 0:
        writeFile.write("\n")
        writeFile.write("============== U14+ GAMES MISSING BOTH ARS: ==============\n")
        writeFile.write("== Referee to be contacted and removed if not comfortable. ==\n")
    for game in without_ars:
        writeFile.write("@" + game.location + " - " + game.time + " - " + game.age + " - " + "#" + str(game.num) + "\n")
    if len(small_without_ref) != 0:
        writeFile.write("\n")
        writeFile.write("============== U10-U12 GAMES MISSING REFEREE ==============\n")
    for game in small_without_ref:
        writeFile.write("@" + game.location + " - " + game.time + " - " + game.age + " - " + "#" + str(game.num) + "\n")
    writeFile.close()

def loadReferees():
    line_count = 0
    email_snd = ""
    with open(REF_FILE, 'r') as csv_file:
        csv_reader = csv.reader(csv_file, delimiter=',')
        for row in csv_reader:
            if line_count == 0:
                # print(f'Column names are {", ".join(row)}')
                line_count += 1
            else:
                if row[8] == "":
                    email_snd = ""
                else:
                    email_snd = row[8]
                ref = Referee(row[0], row[1], row[2], row[4], row[5], row[7], email_snd)
                referee_list.append(ref)

class Game:
    def __init__(self, num, age, location, time, date, position):
        self.num = num
        self.age = age
        self.location = location
        self.time = time
        self.date = date
        self.position = position

class Referee:
    def __init__(self, first_name, last_name, gender, age, yrs_expr, email, email_snd):
        self.first_name = first_name
        self.last_name = last_name
        self.gender = gender
        self.age = age
        self.yrs_expr = yrs_expr
        self.email = email
        self.email_snd = email_snd

main()
