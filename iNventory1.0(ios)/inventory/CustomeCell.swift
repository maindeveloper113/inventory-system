//
//  CustomeCell.swift
//  inventory
//
//  Created by admin on 1/25/17.
//  Copyright © 2017 admin. All rights reserved.
//

import UIKit

class CustomeCell: UITableViewCell {

    @IBOutlet var photo: UIImageView!
    
    @IBOutlet var location: UILabel!
    
    @IBOutlet var partNumber: UILabel!
    
    @IBOutlet var serialNumber: UILabel!
    
    @IBOutlet var quantity: UILabel!
    
    
    @IBOutlet var descript: UILabel!
    
    
    
    @IBOutlet var remark: UILabel!
    
    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
    }

    override func setSelected(_ selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)

        // Configure the view for the selected state
    }

}
