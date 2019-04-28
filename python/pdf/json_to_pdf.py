import configparser
import PyPDF2
import json
import datetime
import pdfkit


import os

print (os.getcwd())

def generate_header(salutation, name, surname, address, zip, city, phone, email):
    """
    This function generates the header pdf page
    """
    # first we take the html file and parse it as a string
    print('generating header page', surname, name)
    with open('header.html', 'r') as myfile:
        data = myfile.read()
        to_write = data.format(salutation, surname, name)
        pdfkit.from_string(to_write, '/tmp/header.pdf')
    
    return open('/tmp/header.pdf', 'rb')

def generate_messages(message, senders, index):
    """
    This function generates the messages pdf page
    """
    print('generating message page', index)
    config = configparser.ConfigParser()
    config.read('pdfconfig.ini')

    base = config['DEFAULT']['Line']
    # first we generate the whole string to insert
    address_string = ''
    for sender in senders:
        name = sender['name']
        location = sender['location']
        address_string += base.format(name, location)
        




    with open('message.html', 'r') as myfile:
        data = myfile.read()
        to_write = data.format(index, message, address_string)
        pdfkit.from_string(to_write, '/tmp/message' + index + '.pdf')
    
    
    return open('/tmp/message' + index + '.pdf', 'rb')

def stich_together(header_page, message_pages, name, surname):
    """
    This function stiches multiple pdfs together
    """
    print('merging page', surname, name)
    # get the current date
    date = str(datetime.datetime.now().year) + str(datetime.datetime.now().month) + str(datetime.datetime.now().day)
    # generate the filename based on date and name
    filename = date + '_' + surname + '_' + name
    # generate the path from date
    path = '../../data/' + date
    # generate the filepath with filename
    complete_file_path = path + '/' + filename
    # make the needed directories
    os.makedirs(path, exist_ok=True)

    
    # use the pdf merger to generate a 'merger' object
    merger = PyPDF2.PdfFileMerger()
    # append the header page
    merger.append(header_page)
    # append all other pages
    for page in message_pages:
        merger.append(page)

    # open the file for saving the pdf
    out_pdf = open(complete_file_path,'wb+')

    # finally write all data into a complete pdf file
    merger.write(out_pdf)
    merger.close()
    # close the file
    out_pdf.close()
    

# open the json file
with open('../../data/messages.json') as json_file:
    # read out the data from the json file
    data = json.load(json_file)

    output_files = []
    
    # loop over politicans
    for poli in data['politicians']:
        print (poli['name'])
        header_page = generate_header(
            salutation=poli['salutation'],
            name=poli['name'],
            surname=poli['surname'],
            address=poli['address'],
            zip=poli['zip'],
            city=poli['city'],
            phone=poli['phone'],
            email=poli['email']
        )
        
        index = 1
        message_pages = []
        for message in poli['messages']:
            message_pages.append(generate_messages(
                message=message['text'],
                senders=message['senders'],
                index=str(index)
            ))
            index += 1

        stich_together(
            header_page=header_page,
            message_pages=message_pages,
            name=poli['name'],
            surname=poli['surname']
        )






