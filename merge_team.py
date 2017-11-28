import csv
import shutil

with open('injuries.csv', 'r') as csv_file:
    csv_reader_injuries = csv.DictReader(csv_file)

    with open('team.csv', 'r') as csv_file1:
        csv_reader_team = csv.DictReader(csv_file1)
        team = {}
        for line in csv_reader_team:
            team[line['TEAM_NAME']] = line['TEAM_ID']

        with open('new_file.csv', 'w') as new_file:
            fieldnames = ['INJURY_ID', 'TEAM_ID', 'DATE', 'PLAYER', 'INJURY']

            csv_writer = csv.DictWriter(new_file, fieldnames=fieldnames, delimiter=',')

            csv_writer.writeheader()

            for line_injuries in csv_reader_injuries:
                line = line_injuries
                line['TEAM_ID'] = team[line_injuries['TEAM']]
                del line['TEAM']
                csv_writer.writerow(line)


shutil.move('new_file.csv', 'injuries.csv')