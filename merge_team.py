import csv
import shutil

with open('GAME.csv', 'r') as csv_file:
    csv_reader_game = csv.DictReader(csv_file)

    with open('team.csv', 'r') as csv_file1:
        csv_reader_team = csv.DictReader(csv_file1)
        team = {}
        for line in csv_reader_team:
            team[line['TEAM_NAME']] = line['TEAM_ID']

        with open('new_file.csv', 'w') as new_file:
            fieldnames = ['GAME_ID','Date','Start (ET)','Visitor_ID','Visitor_PTS','Home_ID','Home_PTS','Notes']

            csv_writer = csv.DictWriter(new_file, fieldnames=fieldnames, delimiter=',')

            csv_writer.writeheader()

            for line_award in csv_reader_game:
                line = line_award
                if line_award['Visitor/Neutral'] == 'Los Angeles Clippers':
                    line['Visitor_ID'] = team['LA Clippers']
                else:
                    line['Visitor_ID'] = team[line_award['Visitor/Neutral']]
                if line_award['Home/Neutral'] == 'Los Angeles Clippers':
                    line['Home_ID'] = team['LA Clippers']
                else:
                    line['Home_ID'] = team[line_award['Home/Neutral']]
                del line['Visitor/Neutral']
                del line['Home/Neutral']
                csv_writer.writerow(line)


shutil.move('new_file.csv', 'games.csv')
#Visitor/Neutral  Home/Neutral
