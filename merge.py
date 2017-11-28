import csv
import shutil

with open('player_performance.csv', 'r') as csv_file:
    csv_reader = csv.DictReader(csv_file)

    with open('new_file.csv', 'w') as new_file:
        fieldnames = ['PLAYER_ID','GP','MIN','FGM','FGA','FG_PCT','FG3M','FG3A','FG3_PCT',
                      'FTM','FTA','FT_PCT','OREB','DREB','REB','AST','STL','BLK','TOV','PTS','EFF']

        csv_writer = csv.DictWriter(new_file, fieldnames=fieldnames, delimiter=',')

        csv_writer.writeheader()

        for line in csv_reader:
            del line['RANK']
            del line['PLAYER']
            del line['TEAM']
            csv_writer.writerow(line)

    shutil.move('new_file.csv', 'player_performance.csv')